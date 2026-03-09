<?php

namespace App\Controller\Admin;

use App\Repository\RouteRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\AvisRepository;
use App\Service\MongoService;
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
        AvisRepository $avisRepo,
        MongoService $mongo
    ): Response {
        // Trajets
        $totalRoutes = count($routeRepo->findAll());
        $routesPerMonth = $routeRepo->countPerMonthLast12();
        $reservationsPerMonth = $reservationRepo->countPerMonthLast12();
        $usersPerMonth = $userRepo->countPerMonthLast12();
        
        $routesPerMonth = array_column($routesPerMonth, 'total');
        $reservationsPerMonth = array_column($reservationsPerMonth, 'total');
        $usersPerMonth = array_column($usersPerMonth, 'total');

        // Réservations
        $totalReservations = count($reservationRepo->findAll());
        $confirmationRate = $reservationRepo->getGlobalConfirmationRate();

        // Utilisateurs
        $totalUsers = count($userRepo->findAll());
        $averageUsersPerMonth = round(array_sum($userRepo->countPerMonthLast12()) / 12, 1);

        // Avis
        $averageRating = $avisRepo->getAverageRating();

        // Flux crédits
        $totalCredits = $reservationRepo->getTotalCredits();

        $activityLogs = $mongo
            ->getCollection('ecoride', 'activity')
            ->find([], ['limit' => 5])
            ->toArray();

        // Mois
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'];

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
            'months' => $months,
            'activityLogs' => $activityLogs,
            'reservationsPerMonth' => $reservationsPerMonth,
            'usersPerMonth' => $usersPerMonth,
        ]);
    }
}
