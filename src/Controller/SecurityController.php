<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /* транзакционные email
        - регистрация - письмо об успешной регистрации
        - восстановление пароля – письмо со ссылкой на страницу сброса пароля
        - сброс пароля – письмо о сбросе пароля
    */


    /**
     * @Route("/login", name="app_login", methods="GET|POST")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
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
     * @param TranslatorInterface $translator
     * @param LoggerInterface $logger
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $formAuthenticator,
        TranslatorInterface $translator,
        LoggerInterface $logger,
        \Swift_Mailer $mailer
    )
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            /* Send email */
            $message = (new \Swift_Message('You successfully registered'))
                ->setFrom($this->parameterBag->get('admin_email'))
                ->setTo('akim_now@mail.ru')
                ->setBody(
                    $this->renderView(
                        'emails/register.html.twig',
                        ['name' => $user->getName()]
                    ),
                    'text/html'
                )
            ;
            $result = $mailer->send($message);

            /* Write to log */
            $logger->info('User created', [
                'user_id' => $user->getId(),
            ]);

            /* Add flash message */
            $this->addFlash(
                'success',
                $translator->trans('%_flash_message_user_registered_%') . $result
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
    public function forgotPassword(Request $request, UserRepository $userRepository, TranslatorInterface $translator)
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

            $resetLink = $this->generateUrl('app_reset_password', [
                'token' => $token
            ]);

            return $this->redirectToRoute('app_reset_password', [
                'token' => $token
            ]);

            // отправить ссылку в емейле

            $this->addFlash(
                'success',
                $translator->trans('%_flash_message_reset_password_requested_%')
            );
        }

        return $this->render('security/forgot.html.twig');
    }

    /**
     * @Route("/reset-password/{token}", name="app_reset_password")
     * @param UserRepository $userRepository
     * @param string $token
     * @return Response
     */
    public function resetPassword(UserRepository $userRepository, string $token)
    {
        $user = $userRepository->findOneBy([
            'resetToken' => $token
        ]);

        if ($user->isResetTokenValid($token)) {

            // поменять пароль
            // clearResetToken()
        }


        return $this->render('security/reset.html.twig');
    }
}
