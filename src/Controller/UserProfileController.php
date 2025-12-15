<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\AppAuthenticator; // ton authenticator de login    

final class UserProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Profil mis à jour avec succès.');

            // Toujours redirection unique
            // return $this->redirectToRoute('app_dashboard');
            // return $this->redirectToRoute('app_homepage');
            return $this->redirectToRoute('app_login');
            
        }

        return $this->render('user_profile/profile.html.twig', [
            'profilForm' => $form->createView(),
            'user' => $user,
        ]);
    }
}
