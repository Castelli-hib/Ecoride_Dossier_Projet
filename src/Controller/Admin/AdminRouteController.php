<?php

namespace App\Controller\Admin;

use App\Repository\RouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/routes')]
#[IsGranted('ROLE_ADMIN')]
class AdminRouteController extends AbstractController
{
    #[Route('/', name: 'admin_routes')]
    public function index(RouteRepository $routeRepo): Response
    {
        return $this->render('admin/route/index.html.twig', [
            'routes' => $routeRepo->findAll(),
        ]);
    }
}
