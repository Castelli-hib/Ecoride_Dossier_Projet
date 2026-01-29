<?php

namespace App\Controller\Admin;

use App\Repository\RouteRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/reservations')]
#[IsGranted('ROLE_ADMIN')]
class AdminReservationController extends AbstractController
{
    #[Route('/', name: 'admin_reservations')]
    public function index(ReservationRepository $repo): Response
    {
        return $this->render('admin/reservation/index.html.twig', [
            'reservations' => $repo->findAll(),
        ]);
    }
}
