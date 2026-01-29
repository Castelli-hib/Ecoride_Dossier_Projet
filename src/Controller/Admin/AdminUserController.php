<?php

namespace App\Controller\Admin;

use App\Repository\RouteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserController extends AbstractController
{
    #[Route('/', name: 'admin_users')]
    public function index(UserRepository $userRepo): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepo->findAll(),
        ]);
    }
}
