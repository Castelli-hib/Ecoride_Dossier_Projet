<?php

namespace App\Controller\Api;

use App\Repository\RouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class AdminStatsController extends AbstractController
{
    private RouteRepository $routeRepository;

    public function __construct(RouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    #[Route('/api/admin/stats', name: 'api_admin_stats', methods: ['GET'])]
    public function index(): JsonResponse
    {
        // Total des trajets
        $totalRoutes = $this->routeRepository->countAllRoutes();

        // Trajets par ville (par ville de départ)
        $routesParVille = $this->routeRepository->createQueryBuilder('r')
            ->select('r.departureTown AS town, COUNT(r.id) AS total')
            ->groupBy('r.departureTown')
            ->getQuery()
            ->getResult();

        // Trajets par jour (groupé par departureDay)
        $routesParJour = $this->routeRepository->createQueryBuilder('r')
            ->select('r.departureDay AS day, COUNT(r.id) AS total')
            ->groupBy('r.departureDay')
            ->orderBy('r.departureDay', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->json([
            'total_routes' => $totalRoutes,
            'routes_par_ville' => $routesParVille,
            'routes_par_jour' => $routesParJour,
        ]);
    }
}
