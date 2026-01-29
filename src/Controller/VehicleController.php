<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleFormType;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/mes-vehicules')] // préfixe commun
#[IsGranted('ROLE_USER')]
class VehicleController extends AbstractController
{
    // Liste des véhicules
    #[Route('/', name: 'app_user_vehicles')]
    public function list(VehicleRepository $repo): Response
    {
        $user = $this->getUser();
        $vehicles = $repo->findByUser($user);

        return $this->render('vehicle/list.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    // Ajouter un véhicule
    #[Route('/ajouter', name: 'app_dashboard_add_vehicle')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleFormType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle->setUserVehicle($this->getUser());
            $vehicle->setStatus('disponible');
            $em->persist($vehicle);
            $em->flush();
            $this->addFlash('success', 'Véhicule ajouté.');
            return $this->redirectToRoute('app_user_vehicles');
        }

        return $this->render('vehicle/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
