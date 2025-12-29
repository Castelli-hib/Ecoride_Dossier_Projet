<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileFormType;
use App\Repository\RouteRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UserProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function profile(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $form = $this->createForm(UserProfileFormType::class, $user, [
            'show_roles' => true, // activation de la modification des roles
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); // sauvegarde en base
            $this->addFlash('success', 'Profil mis à jour avec succès.');
            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user_profile/profile.html.twig', [
            'profilForm' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/dashboard', name: 'app_user_dashboard')]
    public function dashboard(
        RouteRepository $routeRepo,
        ReservationRepository $resRepo
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        // Lecture des données liées
        $routes = $routeRepo->findBy(['user' => $user]);         // Trajets créés
        $reservations = $resRepo->findBy(['passager' => $user]); // Réservations

        return $this->render('user_profile/dashboard.html.twig', [
            'user' => $user,
            'routes' => $routes,
            'reservations' => $reservations,
        ]);
    }
}
