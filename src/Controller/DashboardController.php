<?php

namespace App\Controller;

use App\Entity\Route as AppRoute;
use App\Form\RouteFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER'); // empeche l'accès si non connecté

        // $user = $this->getUser();

        // $isConducteur = $this->isGranted('ROLE_CONDUCTEUR');
        // $isPassager   = $this->isGranted('ROLE_PASSAGER');

        // Si conducteur → ses trajets
        // $routes = $isConducteur ? $em->getRepository(AppRoute::class)->findBy(['user' => $user]) : [];
        $routes = [];
        // Si passager → ses réservations (a implémenter plus tard)
        // $reservations = $isPassager ? [] : [];
        $reservations = []; 

        return $this->render('pages/user/dashboard.html.twig', [
            // 'user'         => $user,
            // 'isConducteur' => $isConducteur,
            // 'isPassager'   => $isPassager,
            'routes'       => $routes,
            'reservations' => $reservations,
        ]);
    }

    #[Route('/dashboard/add-route', name: 'app_dashboard_add_route')]
    public function addRoute(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CONDUCTEUR'); // logique : seuls les conducteurs ajoutent des trajets

        $route = new AppRoute();
        $form = $this->createForm(RouteFormType::class, $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
