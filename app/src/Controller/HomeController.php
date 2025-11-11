<?php

namespace App\Controller;

use App\Entity\Route as AppRoute;
use App\Repository\RouteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(RouteRepository $routeRepository): Response
    {
        // récupère tous les trajets
        // $routes = $routeRepository->findAll();
        $routes = $routeRepository->findLatest(3);

        return $this->render('index.html.twig', [
            'routes' => $routes,
            
        ]);
}
    #[Route('/contact', name: 'app_contact')]
public function contact(Request $request, EntityManagerInterface $em): Response
{
    $contact = new Contact();
    $form = $this->createForm(ContactType::class, $contact);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($contact);
        $em->flush();

        $this->addFlash('success', 'Votre message a bien été envoyé.');
        return $this->redirectToRoute('app_contact');
    }

    return $this->render('contact.html.twig', [
        'form' => $form->createView(),
    ]);
}


}
