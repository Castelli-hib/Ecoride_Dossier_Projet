<?php

namespace App\Controller;


use App\Repository\CreditRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/credits')]
class CreditController extends AbstractController
{
    #[Route('/', name: 'credits_index')]
    public function index(CreditRepository $creditRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('credits/index.html.twig', [
            'balance' => $creditRepository->getBalanceForUser($user),
            'credits' => $creditRepository->findLatestForUser($user),
        ]);
    }
}
