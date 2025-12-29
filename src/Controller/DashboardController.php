<?php

namespace App\Controller;

use App\Entity\Route as AppRoute;
use App\Form\RouteFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        // Sécurité : uniquement pour les utilisateurs connectés
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $isConducteur = $this->isGranted('ROLE_CONDUCTEUR');
        $isPassager   = $this->isGranted('ROLE_PASSAGER');

        // Si conducteur → récupérer ses trajets
        $routes = $isConducteur ? $em->getRepository(AppRoute::class)->findBy(['user' => $user]) : [];

        // Si passager → récupérer ses réservations (à compléter si nécessaire)
        $reservations = $isPassager ? [] : [];

        return $this->render('pages/user/dashboard.html.twig', [
            'user'         => $user,
            'isConducteur' => $isConducteur,
            'isPassager'   => $isPassager,
            'routes'       => $routes,
            'reservations' => $reservations,
        ]);
    }

    #[Route('/dashboard/add-route', name: 'app_dashboard_add_route')]
    public function addRoute(Request $request, EntityManagerInterface $em): Response
    {
        // Seuls les conducteurs peuvent ajouter des trajets
        $this->denyAccessUnlessGranted('ROLE_CONDUCTEUR');

        $route = new AppRoute();
        $form = $this->createForm(RouteFormType::class, $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Lier le trajet à l'utilisateur connecté
            $route->setUser($this->getUser());
            $em->persist($route);
            $em->flush();

            $this->addFlash('success', 'Trajet ajouté avec succès');
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/add_route.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }
}
