<?php

namespace App\Controller\Admin;

use App\Repository\RouteRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractController
{
    #[Route('/', name: 'admin_dashboard')]
    public function index(
        RouteRepository $routeRepo,
        ReservationRepository $reservationRepo,
        UserRepository $userRepo,
        AvisRepository $avisRepo
    ): Response
    {
        // Trajets
        $totalRoutes = count($routeRepo->findAll());
        $routesPerMonth = $routeRepo->countPerMonthLast12();

        // Réservations
        $totalReservations = count($reservationRepo->findAll());
        $confirmationRate = $reservationRepo->getConfirmationRate();

        // Utilisateurs
        $totalUsers = count($userRepo->findAll());
        $averageUsersPerMonth = round(array_sum($userRepo->countPerMonthLast12()) / 12, 1);

        // Avis
        $averageRating = $avisRepo->getAverageRating();

        // Flux crédits
        $totalCredits = $reservationRepo->getTotalCredits();

        // Mois
        $months = ['Jan','Feb','Mar','Apr','Mai','Juin','Juil','Aout','Sept','Oct','Nov','Dec'];

        // RENDER
        return $this->render('admin/dashboard.html.twig', [
            'totalRoutes' => $totalRoutes,
            'routesPerMonth' => $routesPerMonth,
            'totalReservations' => $totalReservations,
            'confirmationRate' => $confirmationRate,
            'totalUsers' => $totalUsers,
            'averageUsersPerMonth' => $averageUsersPerMonth,
            'averageRating' => $averageRating,
            'totalCredits' => $totalCredits,
            'months' => $months
        ]);
    }
}
