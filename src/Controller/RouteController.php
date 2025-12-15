<?php

namespace App\Controller;

use App\Repository\RouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RouteController extends AbstractController
{
    #[Route('/mes-trajets', name: 'app_user_routes')]
    #[IsGranted('ROLE_USER')]
    public function mesTrajets(RouteRepository $routeRepository): Response
    {
        // 🔹 Récupération de l’utilisateur connecté
        $user = $this->getUser();

        // 🔹 Récupération des trajets liés à cet utilisateur
        $routes = $routeRepository->findBy(['user' => $user]);

        return $this->render('route/mes_trajets.html.twig', [
            'user' => $user,
            'routes' => $routes,
        ]);
    }

    #[Route('/tous-les-trajets', name: 'app_all_routes')]
    public function allRoutes(RouteRepository $routeRepository): Response
    {
        // 🔹 Tous les trajets existants
        $routes = $routeRepository->findAll();

        return $this->render('route/all_routes.html.twig', [
            'routes' => $routes,
        ]);
    }
}
