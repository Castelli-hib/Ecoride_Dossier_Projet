<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('pages/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    
    #[Route('/profile_user', name: 'app_profile_user')]
    public function profile_user(): Response
    {
        return $this->render('pages/user/profile_user.html.twig', [
            'controller_name' => 'ProfileUser',
        ]);
    }

    #[Route('/historical', name: 'app_historical')]
    public function historical(): Response
    {
        return $this->render('pages/user/historical.html.twig', [
            'controller_name' => 'Historical',
        ]);
    }
    #[Route('/reservation', name: 'app_reservation')]
    public function reservation(): Response
    {
        return $this->render('pages/user/reservation.html.twig', [
            'controller_name' => 'Reservation',
        ]);
    }
    #[Route('/route_creation', name: 'app_route_creation')]
    public function routeCreation(): Response
    {
        return $this->render('pages/user/route_creation.html.twig', [
            'controller_name' => 'RouteCreation',
        ]);
    }



}
