<?php

namespace App\Controller;

use App\Entity\Route as AppRoute;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    // 
    // #[Route('/covoiturage', name: 'app_covoiturage')]
    // public function covoiturage(EntityManagerInterface $em): Response
    // {
    //     // Récupérer tous les trajets
    //     $routes = $em->getRepository(AppRoute::class)->findAll();

    //     return $this->render('covoiturage/index.html.twig', [
    //         'routes' => $routes,
    //     ]);
    // }


}
