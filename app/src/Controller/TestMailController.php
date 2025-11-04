<?php

namespace App\Controller;

use App\Service\SendEmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestMailController extends AbstractController
{
    #[Route('/test-mail', name: 'test_mail')]
    public function testMail(SendEmailService $mailer): Response
    {
        $mailer->send(
            'no-reply@ecoride.fr',
            'ton.email@exemple.com',
            'Test email Twig',
            'emails/password_reset.html.twig',
            ['user' => 'Marie', 'token' => '123456']
        );

        return new Response('Mail envoyé !');
    }
}
