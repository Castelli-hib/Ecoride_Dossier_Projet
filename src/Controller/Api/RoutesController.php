<?php

namespace App\Controller\Api;

use App\Entity\Route as RouteEntity; // Renommage pour éviter conflit avec Route annotation
use App\Repository\RouteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route as ApiRoute; // Renommage de l'annotation Route pour éviter conflit

#[ApiRoute('/api/routes')]
class RoutesController extends AbstractController
{
    // ========================
    // LISTE DES TRAJETS
    // ========================
    #[ApiRoute('', methods: ['GET'])]
    public function list(RouteRepository $routeRepository): JsonResponse
    {
        // ✅ On force le chargement du user avec join pour éviter "user: []"
        $routes = $routeRepository->createQueryBuilder('r')
            ->leftJoin('r.user', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();

        return $this->json(
            $routes,
            200,
            [],
            ['groups' => 'route:read'] // ✅ Sérialisation avec le groupe
        );
    }

    // ========================
    // AFFICHER UN TRAJET PAR ID
    // ========================
    #[ApiRoute('/{id}', methods: ['GET'])]
    public function show(?RouteEntity $route): JsonResponse
    {
        if (!$route) {
            return $this->json(['error' => 'Route not found'], 404);
        }

        // ✅ Toujours utiliser le groupe 'route:read' pour la sérialisation
        return $this->json(
            $route,
            200,
            [],
            ['groups' => 'route:read']
        );
    }

    // ========================
    // CRÉER UN TRAJET
    // ========================
    #[ApiRoute('', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // ✅ Sécurité JSON : vérifier que les données existent
        if (!$data) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        $route = new RouteEntity();

        // ========================
        // Champs obligatoires
        // ========================
        $route->setDepartureTown($data['departureTown']);
        $route->setArrivalTown($data['arrivalTown']);
        $route->setDepartureDay(new \DateTime($data['departureDay']));
        $route->setDepartureTime(new \DateTime($data['departureTime']));
        $route->setTravelTime($data['travelTime']);

        // ========================
        // Correspondance
        // ========================
        
        $route->setCorrespondance($data['correspondance'] ?? false);
        $route->setCorrespondanceDetail($data['correspondanceDetail'] ?? null);

        // ========================
        // Options du trajet
        // ========================
        $route->setAllowAnimal($data['allowAnimal'] ?? false);
        $route->setAllowSmoker($data['allowSmoker'] ?? false);
        $route->setAllowMusic($data['allowMusic'] ?? true);
        $route->setAllowDisabledEquipment($data['allowDisabledEquipment'] ?? false);

        // ========================
        // Utilisateur créateur
        // ========================
        // Décommenter si je veux lier le trajet à l'utilisateur connecté
        // $route->setUser($this->getUser());

        // ========================
        // Persistance
        // ========================
        $em->persist($route);
        $em->flush();

        return $this->json(['id' => $route->getId()], 201);
    }
}
