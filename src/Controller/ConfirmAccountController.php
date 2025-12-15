<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConfirmAccountController extends AbstractController
{
    public function __construct(
        private JWTService $jwt,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {}
    #[Route('/confirm/account/{token}', name: 'app_confirm_account')]
    public function index(string $token) {
        // Vérifier le token
        if (!$this->jwt->isValid($token) || $this->jwt->isExpired($token) || 
        $this->jwt->check($token, $this->getParameter('app.jwtsecret')) === false) {
            return $this->redirectToRoute('app_homepage');
        }
       $userId = $this->jwt->getPayload($token)['user_id'];
       $user= $this->userRepository->find($userId);
       if (!$user) {
           return $this->redirectToRoute('app_homepage');
       }
       $user->setIsVerified(true);
       $this->entityManager->persist($user);
       $this->entityManager->flush();

        return $this->redirectToRoute('app_login');
    }
}
