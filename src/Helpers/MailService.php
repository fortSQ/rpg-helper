<?php

namespace App\Helpers;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class MailService
{
    private $mailer;
    private $router;
    private $logger;
    private $twig;
    private $parameterBag;
    private $noReplyEmail;

    public function __construct(
        \Swift_Mailer $mailer,
        RouterInterface $router,
        LoggerInterface $logger,
        \Twig_Environment $twig,
        ParameterBagInterface $parameterBag,
        string $noReplyEmail
    )
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->logger = $logger;
        $this->twig = $twig;
        $this->parameterBag = $parameterBag;
        $this->noReplyEmail = $noReplyEmail;
    }

    public function sendMessage($templateName, $context, $fromEmail, $toEmail)
    {
        $context = $this->twig->mergeGlobals($context);
        $template = $this->twig->load($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);
        
        //dump($htmlBody); die('ok');

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
        ;

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $result = $this->mailer->send($message);

        $logContext = [
            'to'       => $toEmail,
            'message'  => $textBody,
            'template' => $templateName
        ];

        if ($result) {
            $this->logger->info('SMTP email sent', $logContext);
        } else {
            $this->logger->error('SMTP email error', $logContext);
        }

        return $result;
    }

    public function sendResetPasswordEmailMessage(User $user)
    {
        $url = $this->router->generate(
            'app_reset_password',
            ['token' => $user->generateResetToken()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $context = [
            'user' => $user,
            'resetPasswordUrl' => $url,
        ];

        $this->sendMessage(
            'emails/request-password.html.twig',
            $context,
            $this->noReplyEmail,
            $user->getEmail()
        );
    }
}