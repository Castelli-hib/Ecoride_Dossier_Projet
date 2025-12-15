<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublicController extends AbstractController
{
    #[Route('/', name: 'app_public')]
    public function index(): Response
    {
        return $this->render('pages/public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }    

    // section public /visiteur
    #[Route('/details', name: 'app_details')]
    public function details(): Response
    {
        return $this->render('pages/public/details.html.twig', [
            'controller_name' => 'Details',
        ]);
    }

    #[Route('/route', name: 'app_route')]
    public function route(): Response
    {
        return $this->render('pages/public/route.html.twig', [
            'controller_name' => 'Route',
        ]);
    }

    #[Route('/legal_mentions', name: 'app_legal_mentions')]
    public function legalMentions(): Response
    {
        return $this->render('pages/public/legal_mentions.html.twig', [
            'controller_name' => 'LegalMentions',
        ]);
    }
}
    