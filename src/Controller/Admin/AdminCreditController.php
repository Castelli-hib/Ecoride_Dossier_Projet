<?php

namespace App\Controller\Admin;

use App\Repository\RouteRepository;
use App\Repository\CreditRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/credits')]
#[IsGranted('ROLE_ADMIN')]
class AdminCreditController extends AbstractController
{
    #[Route('/', name: 'admin_credits')]
    public function index(CreditRepository $creditRepo): Response
    {
        return $this->render('admin/credit/index.html.twig', [
            'credits' => $creditRepo->findAll(),
        ]);
    }
}
