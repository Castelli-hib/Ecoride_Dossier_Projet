<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Form\AddAvisFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/avis', name: 'app_admin_avis_')]
final class AvisController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    #[Route('/ajouter', name: 'add')]
    public function addAvis(Request $request, EntityManagerInterface $em): Response
    {
        // on initialise un avis vide
        $avis = new Avis();

        // on initialise le formulaire
        $avisForm = $this->createForm(AddAvisFormType::class, $avis);

        // on traite le formulaire
        $avisForm->handleRequest($request);

        if ($avisForm->isSubmitted() && $avisForm->isValid()) {
            // on associe l’utilisateur connecté
            $avis->setUser($this->getUser());

            // on génère un slug 
            $slug = strtolower(str_replace(' ', '-', substr($avis->getComment(), 0, 20)));
            $avis->setSlug($slug);

            // on enregistre
            $em->persist($avis);
            $em->flush();

            $this->addFlash('success', 'Avis ajouté avec succès !');
            return $this->redirectToRoute('app_admin_avis_index');
        }

        // affichage du formulaire
        return $this->render('admin/avis/add.html.twig', [
            'avisForm' => $avisForm->createView(),
        ]);
    }
}
