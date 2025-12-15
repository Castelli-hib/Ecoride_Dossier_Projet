<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
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

        $avisReçus = $avisRepository->findBy(['userRated' => $user]);
        $avisEnvoyés = $avisRepository->findBy(['userRater' => $user]);

        // Calcul note moyenne
        $total = 0;
        $count = count($avisReçus);
        foreach ($avisReçus as $avis) {
            $total += $avis->getNote();
        }
        $moyenne = $count ? $total / $count : null;

        return $this->render('avis/index.html.twig', [
            'avisReçus' => $avisReçus,
            'avisEnvoyes' => $avisEnvoyés,
            'moyenne' => $moyenne,
        ]);
    }

    #[Route('/new', name: 'avis_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $avis = new Avis();
        $avis->setUserRater($this->getUser());
        $avis->setCreatedAt(new \DateTime());

        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($avis);
            $em->flush();

            return $this->redirectToRoute('avis_index');
        }

        return $this->render('avis/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
