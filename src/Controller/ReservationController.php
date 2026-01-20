<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Route as Trip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'reservation_create', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function create(
        Trip $route,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();

        // Vérifie s'il reste des places via la méthode de l'entité
        // if (!$route->hasAvailableSeats()) {
        //     $this->addFlash('danger', 'Plus de places disponibles.');
        //     return $this->redirectToRoute('app_all_routes');
        // }

        // Création de la réservation
        $reservation = new Reservation();
        $reservation->setPassager($user);
        $reservation->setRoute($route);
        $reservation->setDateReservation(new \DateTimeImmutable());

        $em->persist($reservation);
        $em->flush();

        $this->addFlash('success', 'Réservation effectuée.');
        return $this->redirectToRoute('app_user_reservations');
    }

    #[Route('/mes-reservations', name: 'app_user_reservations')]
    #[IsGranted('ROLE_USER')]
    public function list(EntityManagerInterface $em): Response
    {
        $reservations = $em->getRepository(Reservation::class)->findBy([
            'passager' => $this->getUser()
        ]);

        return $this->render('reservation/list.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
