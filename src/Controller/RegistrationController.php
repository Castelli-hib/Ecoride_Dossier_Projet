<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\JWTService;
use App\Service\SendEmailService;

class RegistrationController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager,
        private JWTService $jwt,
        private SendEmailService $mail
    ) {}

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Compte désactivé tant que non vérifié
            $user->setIsVerified(false);
            $existingUser = $this->entityManager
                ->getRepository(User::class)
                ->findOneBy(['email' => $user->getEmail()]);

            if ($existingUser) {
                $this->addFlash('danger', 'Un compte existe déjà avec cet email.');
                return $this->redirectToRoute('app_register');
            }


            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Générer le token JWT (24h)
            $token = $this->jwt->generate(
                ['typ' => 'JWT', 'alg' => 'HS256'],
                [
                    'user_id' => $user->getId(),
                    'email'   => $user->getEmail(),
                ],
                $this->getParameter('app.jwtsecret'),
                86400
            );

            // Envoyer l’email de confirmation
            $this->mail->send(
                'no-reply@ecoride.fr',
                $user->getEmail(),
                'Confirmation d\'inscription',
                'emails/register-email.html.twig',
                compact('user', 'token')
            );

            return $this->redirectToRoute('app_check_email');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/check-email', name: 'app_check_email')]
    public function checkEmail(): Response
    {
        return $this->render('emails/check_email.html.twig');
    }

    #[Route('/verify/{token}', name: 'verify_user')]
    public function verifyUser(string $token): Response
    {
        // Vérifie le token
        if (!$this->jwt->isValid($token) || $this->jwt->isExpired($token) || !$this->jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            $this->addFlash('danger', 'Lien de validation invalide ou expiré.');
            return $this->redirectToRoute('app_register');
        }

        $payload = $this->jwt->getPayload($token);
        $user = $this->entityManager->getRepository(User::class)->find($payload['user_id']);

        if (!$user) {
            $this->addFlash('danger', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_register');
        }

        if ($user->isVerified()) {
            $this->addFlash('info', 'Compte déjà activé.');
            return $this->redirectToRoute('app_login');
        }

        // Activation du compte
        $user->setIsVerified(true);
        $this->entityManager->flush();

        $this->addFlash('success', 'Votre compte a été activé !');
        return $this->redirectToRoute('app_login');
    }
}
