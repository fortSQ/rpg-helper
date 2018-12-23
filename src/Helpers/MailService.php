<?php

namespace App\Helpers;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MailService
{
    private $mailer;
    private $templating;
    private $parameterBag;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, ParameterBagInterface $parameterBag)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->parameterBag = $parameterBag;
    }

    public function sendEmail($subject, $to, $template, array $params, $from = null)
    {
        $from = $from ?? $this->parameterBag->get('admin_email');

        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $this->templating->render($template, $params),
                'text/html'
            )
        ;

        return $this->mailer->send($message);
    }
}