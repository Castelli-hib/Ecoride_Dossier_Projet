<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\AvisRepository;
use App\Repository\CreditRepository;
use App\Repository\ReservationRepository;
use App\Repository\RouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// src/Controller/AdminDashboardController.php

class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(
        RouteRepository $routeRepo,
        ReservationRepository $reservationRepo,
        AvisRepository $avisRepo,
        CreditRepository $creditRepo
    ): Response {
        $totalRoutes = $routeRepo->countAllRoutes();
        $totalReservations = $reservationRepo->countAllReservations();
        $confirmationRate = $reservationRepo->getGlobalConfirmationRate();
        $averageRating = $avisRepo->getAverageRating();
        $totalCredits = $creditRepo->getTotalCredits();

        // DONNÉES DU GRAPHIQUE 
        $months = [
            'Janvier',
            'Février',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Septembre',
            'Octobre',
            'Novembre',
            'Décembre'
        ];

        $routesPerMonth = [12, 19, 3, 5, 2, 3, 7, 8, 6, 4, 9, 11];

        return $this->render('admin/dashboard.html.twig', [
            'totalRoutes' => $totalRoutes,
            'totalReservations' => $totalReservations,
            'confirmationRate' => $confirmationRate,
            'averageRating' => $averageRating,
            'totalCredits' => $totalCredits,
            'months' => $months,
            'routesPerMonth' => $routesPerMonth,
        ]);
    }
}
