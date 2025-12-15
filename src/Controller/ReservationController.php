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
    #[Route('/reservation/{id}', name:'reservation_create', methods:['POST'])]
    #[IsGranted('ROLE_USER')]
    public function create(
        Trip $route,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();

        if ($route->getAvailableSeats() <= 0) {
            $this->addFlash('danger', 'Plus de places disponibles.');
            return $this->redirectToRoute('app_all_routes');
        }

        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setRoute($route);

        $route->setAvailableSeats($route->getAvailableSeats() - 1);

        $em->persist($reservation);
        $em->flush();

        $this->addFlash('success', 'Réservation effectuée.');
        return $this->redirectToRoute('app_user_reservations');
    }

    #[Route('/mes-reservations', name:'app_user_reservations')]
    #[IsGranted('ROLE_USER')]
    public function list(EntityManagerInterface $em): Response
    {
        $reservations = $em->getRepository(Reservation::class)->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('reservation/list.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
