<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class SendEmailService
{
    // Construction avec PHP 8
    public function __construct(private MailerInterface $mailer)
    {}
    public function send(
        string $from, 
        string $to,
        string $subject, 
        string $template,
        array $context
    ): void
    {
        // on crée le mail
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template . '.html.twig')
            ->context($context);

        // On envoie le mail
        $this->mailer->send($email);
    }
}

