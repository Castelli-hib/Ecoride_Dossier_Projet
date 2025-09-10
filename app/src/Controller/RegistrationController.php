<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\JWTService;
use App\Service\SendEmailService;
use App\Repository\UserRepository;

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
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // do anything else you need here, like send an email
            
            // Générer le token JWT pour confirmation email
            $token = $this->jwt->generate(
                ['typ'=>'JWT','alg'=>'HS256'],
                [
                    'user_id' => $user->getId(),
                    'email'   => $user->getEmail()
                ],
                $this->getParameter('app.jwtsecret'),
                86400 // validité 24h
            );

            // Envoyer le mail de confirmation
            $this->mail->send(
                'no-reply@ecoride.fr',
                $user->getEmail(),
                'Confirmation d\'inscription',
                'emails/register-email.html.twig',
                compact('user', 'token')//['user' => $user, 'token' => $token]
            );
            //  $this->addFlash('success', 'Utilisateur inscrit, cliquez sur le lien pour confirmer votre adresse mail !');

            // Rediriger vers la page qui indique à l'utilisateur de vérifier son email
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
        // Vérifie la validité et la signature du token
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

        $user->setIsVerified(true);
        $this->entityManager->flush();

        $this->addFlash('success', 'Votre compte a été activé !');
        return $this->redirectToRoute('app_login');
    }

    
    #[Route('/verif/{token}', name: 'verif_user')]
    public function verifUser($token, JWTService $jwt, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        // 1. Vérifier si le token est valide (cohérent, pas expiré et correct)
        if (!$jwt->isValid($token) && $jwt->isExpired($token) && !$jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            //Le token est valide
            //On recupere les données
            $payload = $jwt->getPayload($token);
            
            //On recupere l'utilisateur
            $user = $userRepository->find($payload['user_id']);

            // on vérifie qu’on a bien un user et qu’il n’est pas déjà activé
            if($user && !$user->isVerified());
                $user->setIsVerified(true);
                $em->flush();

                $this->addFlash('success', 'Votre compte a bien été activé !');
                return $this->redirectToRoute('app_homepage');
        }
        
                $this->addFlash('Attention', 'Le token est invalide ou a déjà expiré');
                return $this->redirectToRoute('app_login');
    }
}
