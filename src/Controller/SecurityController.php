<?php

namespace App\Controller;

use App\Entity\ResetPasswordTrait;
use App\Form\ResetPasswordType;
use App\Helpers\MailService;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    private $logger;
    private $translator;
    private $mailer;

    public function __construct(LoggerInterface $logger, TranslatorInterface $translator, MailService $mailer)
    {
        $this->logger = $logger;
        $this->translator = $translator;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/login", name="app_login", methods="GET|POST")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        // POST request is handled in \src\Security\LoginFormAuthenticator.php

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('Will be intercepted before getting here');
    }

    /**
     * @Route("/register", name="app_register", methods="GET|POST")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $formAuthenticator
     * @return Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $formAuthenticator
    )
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            /* Send email */
            $this->mailer->sendEmail(
                'You successfully registered',
                $user->getEmail(),
                'emails/register.html.twig',
                [
                    'name' => $user->getName()
                ]
            );

            /* Write to log */
            $this->logger->info('User created', [
                'user_id' => $user->getId(),
            ]);

            /* Flash message */
            $this->addFlash(
                'success',
                $this->translator->trans('%_flash_message_user_registered_%')
            );

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $formAuthenticator,
                'main'
            );
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forgot-password", name="app_forgot_password", methods="GET|POST")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function forgotPassword(Request $request, UserRepository $userRepository)
    {
        if ($request->isMethod('POST')) {
            $user = $userRepository->findOneBy([
                'email' => $request->request->get('email')
            ]);

            if (null == $user) {
                return $this->render('security/forgot.html.twig', [
                    'last_email' => $request->request->get('email'),
                ]);
            }

            $token = $user->generateResetToken(new \DateInterval('PT1H'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            /* Send email */
            $this->mailer->sendEmail(
                'Reset your password',
                $user->getEmail(),
                'emails/reset.html.twig',
                [
                    'name'  => $user->getName(),
                    'token' => $token
                ]
            );

            /* Flash message */
            $this->addFlash(
                'success',
                $this->translator->trans('%_flash_message_reset_password_requested_%')
            );
        }

        return $this->render('security/forgot.html.twig');
    }

    /**
     * @Route("/reset-password/{token}", name="app_reset_password")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param string $token
     * @return Response
     */
    public function resetPassword(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, string $token)
    {
        $user = $userRepository->findOneBy([
            'resetToken' => $token
        ]);

        if (!isset($user) || !$user->isResetTokenValid($token)) {
            throw new NotFoundHttpException("Reset password token doesn't exist or is not valid");
        }

        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($newEncodedPassword);
            $user->clearResetToken();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            /* Send email */
            $this->mailer->sendResetPasswordEmailMessage(
                'Your password successfully changed',
                $user->getEmail(),
                'emails/password_changed.html.twig',
                [
                    'name'  => $user->getName()
                ]
            );

            /* Flash message */
            $this->addFlash(
                'success',
                $this->translator->trans('%_password_changed_%')
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
