<?php

namespace App\Controller;

use App\Form\ResetPasswordRequestFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SecurityController extends AbstractController
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    // #[Route('/register', name: 'app_register')]
    // public function register(): Response
    // {
    //     return $this->render('pages/security/register.html.twig');
    // }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Redirige déjà connecté
        if ($this->getUser()) {
            return $this->redirectToRoute('app_homepage');
        }

        // Récupère les erreurs éventuelles
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/forgot_password', name: 'app_forgot_password')]
    public function forgotPassword(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/forgot_password.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);             
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony intercepte automatiquement cette route
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/forgot_password', name: 'forgotten_password')]
    public function forgottenPassword()
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        return $this->render('security/forgot_password.html.twig', [
            'requestPasswordForm' => $form->createView(),
        ]);
    }
}
