<?php

namespace App\Controller\Admin;

use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/avis')]
#[IsGranted('ROLE_ADMIN')]  
class AdminAvisController extends AbstractController
{
    #[Route('/admin/avis', name: 'admin_avis')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(AvisRepository $avisRepo): Response
    {
        return $this->render('admin/avis/index.html.twig', [
            'avis' => $avisRepo->findAll(),
        ]);
    }
}