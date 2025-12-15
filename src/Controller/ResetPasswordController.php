<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticatorManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset-password', name: 'app_forgot_password_request')]
    public function request(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        // Formulaire simple pour saisir l’e-mail
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'attr' => ['placeholder' => 'Entrez votre e-mail']
            ])
            ->add('submit', SubmitType::class, ['label' => 'Envoyer le lien'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailValue = $form->get('email')->getData();
            $user = $em->getRepository(User::class)->findOneBy(['email' => $emailValue]);

            if (!$user) {
                $this->addFlash('danger', 'Aucun compte trouvé avec cette adresse.');
                return $this->redirectToRoute('app_forgot_password_request');
            }

            // Génération d’un token simple
            $token = bin2hex(random_bytes(32));
            $user->setResetToken($token);
            $em->flush();

            // 🔗 Génération du lien absolu
            $resetUrl = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            // ✉️ Envoi du mail avec ton template Twig
            $email = (new TemplatedEmail())
                ->from('no-reply@ecoride.fr')
                ->to($user->getEmail())
                ->subject('Réinitialisation de votre mot de passe - Ecoride')
                ->htmlTemplate('emails/password_reset.html.twig')
                ->context([
                    'user' => $user,
                    'resetUrl' => $resetUrl,
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Un lien de réinitialisation vous a été envoyé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function reset(
        string $token,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $em->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'Lien invalide ou expiré.');
            return $this->redirectToRoute('app_forgot_password_request');
        }

        // Formulaire de nouveau mot de passe
        $form = $this->createFormBuilder()
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Changer le mot de passe'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);
            $user->setResetToken(null);
            $em->flush();

            $this->addFlash('success', 'Mot de passe réinitialisé avec succès.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}
