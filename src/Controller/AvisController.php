<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisFormType;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/avis')]
class AvisController extends AbstractController
{
    #[Route('/', name: 'avis_index')]
    public function index(AvisRepository $avisRepository): Response
    {
        $user = $this->getUser();

        $avisRecus = $avisRepository->findBy(['userRated' => $user]);
        $avisEnvoyes = $avisRepository->findBy(['userRater' => $user]);

        $total = array_sum(array_map(fn($a) => $a->getNotation(), $avisRecus));
        $count = count($avisRecus);
        $moyenne = $count ? $total / $count : null;

        return $this->render('avis/index.html.twig', [
            'avisRecus' => $avisRecus,
            'avisEnvoyes' => $avisEnvoyes,
            'moyenne' => $moyenne,
        ]);
    }

    #[Route('/new', name: 'avis_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        AvisRepository $avisRepository
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $avis = new Avis();
        $avis->setUserRater($user);

        $form = $this->createForm(AvisFormType::class, $avis, ['is_edit' => false]);
        $form->handleRequest($request);

        // 🔒 RÈGLE MÉTIER : 1 AVIS MAX
        if ($form->isSubmitted() && $form->isValid()) {

            $ratedUser = $avis->getUserRated();

            if ($avisRepository->hasUserRated($user, $ratedUser)) {
                $this->addFlash('warning', 'Vous avez déjà laissé un avis.');
                return $this->redirectToRoute('avis_index');
            }

            $em->persist($avis);
            $em->flush();

            $this->addFlash('success', 'Avis ajouté avec succès !');
            return $this->redirectToRoute('avis_index');
        }

        return $this->render('avis/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'avis_edit')]
    public function edit(Avis $avis, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AvisFormType::class, $avis, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Avis modifié avec succès !');
            return $this->redirectToRoute('avis_index');
        }

        return $this->render('avis/edit.html.twig', [
            'form' => $form->createView(),
            'avis' => $avis,
        ]);
    }
    
}

// dump($_ENV['DATABASE_URL']);
// die;