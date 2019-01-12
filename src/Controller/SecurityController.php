<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use App\Form\ForgotPasswordType;
use App\Security\LoginFormAuthenticator;
use App\Helpers\CaptchaValidator;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidatorException;

class SecurityController extends BaseController
{
    const DOUBLE_OPT_IN = true;

    /**
     * @Route("/login", name="app_login", methods="GET|POST")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        // POST request is handled in \src\Security\LoginFormAuthenticator.php

        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('app_homepage'));
        }

        // get the login error if there is one (UsernameNotFoundException)
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
     * @param CaptchaValidator $captchaValidator
     * @return Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        CaptchaValidator $captchaValidator
    )
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            $user = $form->getData();

            try {
                if (!$captchaValidator->validateCaptcha($request->get('g-recaptcha-response'))) {
                    $form->addError(new FormError($this->translator->trans('~error.wrong_captcha')));
                    throw new ValidatorException('Wrong captcha');
                }

                $user->setPassword($passwordEncoder->encodePassword($user, $user->getPlainPassword()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $log_context = [
                    'user_id' => $user->getUsername(),
                    'DOUBLE_OPT_IN' => self::DOUBLE_OPT_IN
                ];

                if (self::DOUBLE_OPT_IN) {
                    $this->logger->info('User created WITH activation', $log_context);
                    $this->requestActivation($user);


                    $this->addFlash('success', $this->translator->trans('~flash_message.user_registered_with_activation'));
                    return $this->redirect($this->generateUrl('app_login'));
                }

                $this->logger->info('User created WITHOUT activation', $log_context);
                $this->addFlash('success', $this->translator->trans('~flash_message.user_registered_without_activation'));

                return $this->redirect($this->generateUrl('app_user_activate', ['token' => $token]));

            } catch (ValidatorException $exception) {

            }
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function requestActivation(User $user)
    {
        $token = $user->generateActivationToken();

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->mailer->sendActivationEmailMessage($user);

        return $token;
    }

    /**
     * @Route("/activate/{token}", name="app_user_activate")
     * @param $request Request
     * @param UserRepository $userRepository
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $formAuthenticator
     * @param string $token
     * @return Response
     */
    public function activate(
        Request $request,
        UserRepository $userRepository,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $formAuthenticator,
        string $token
    )
    {
        $user = $userRepository->findOneBy([
            'activationToken' => $token
        ]);

        if (!$user || !$user->isActivationTokenValid($token)) {
            throw new NotFoundHttpException("Activation token doesn't exist or is not valid");
        }

        $user->setStatus(User::STATUS_ACTIVE)
             ->setActivatedAt(new \DateTime())
             ->clearActivationToken()
             ->clearInactiveReason();

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', $this->translator->trans('~flash_message.user_activated'));

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $formAuthenticator,
            'main'
        );
    }

    /**
     * @Route("/forgot-password", name="app_forgot_password", methods="GET|POST")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param CaptchaValidator $captchaValidator
     * @return Response
     */
    public function forgotPassword(Request $request, UserRepository $userRepository, CaptchaValidator $captchaValidator)
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('app_homepage'));
        }

        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                if (!$captchaValidator->validateCaptcha($request->get('g-recaptcha-response'))) {
                    $form->addError(new FormError($this->translator->trans('~error.wrong_captcha')));
                    throw new ValidatorException('Wrong captcha');
                }

                /** @var User $user */
                $user = $userRepository->findOneBy([
                    'email' => $form->get('email')->getData()
                ]);

                if (!$user) {
                    $form->addError(new FormError($this->translator->trans('~error.user_not_found')));
                    return $this->render('security/forgot.html.twig', [
                        'form' => $form->createView()
                    ]);
                }

                $user->generateResetToken();

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->mailer->sendResetPasswordEmailMessage($user);
                $this->addFlash('success', $this->translator->trans('~flash_message.reset_password_requested'));

                return $this->redirect($this->generateUrl('app_homepage'));
            } catch (ValidatorException $exception) {

            }
        }

        return $this->render('security/forgot.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset-password/{token}", name="app_reset_password")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param string $token
     * @return Response
     */
    public function resetPassword(
        Request $request,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        string $token
    )
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('app_homepage'));
        }

        /** @var User $user */
        $user = $userRepository->findOneBy([
            'resetToken' => $token,
            'status' => User::STATUS_ACTIVE
        ]);

        if (!$user || !$user->isResetTokenValid($token)) {
            throw new NotFoundHttpException("Reset password token doesn't exist or is not valid");
        }

        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPlainPassword()));
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

            $this->addFlash('success', $this->translator->trans('~flash_message.password_changed'));

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
