<?php
// src/Controller/CovoiturageController.php
namespace App\Controller;

use App\Entity\Route as AppRoute;
use App\Form\SearchRideFormType;
use App\Model\SearchRide;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CovoiturageController extends AbstractController
{
    #[Route('/covoiturage', name: 'app_covoiturage')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $search = new SearchRide();
        // la form est configurée en GET
        $form = $this->createForm(SearchRideFormType::class, $search, ['method' => 'GET']);
        $form->handleRequest($request);

        $qb = $em->getRepository(AppRoute::class)->createQueryBuilder('r');

        // Filtre départ (LIKE, insensible à la casse)
        if (!empty($search->departure)) {
            $qb->andWhere('LOWER(r.departureTown) LIKE :departure')
               ->setParameter('departure', '%'.mb_strtolower($search->departure).'%');
        }

        // Filtre arrivée
        if (!empty($search->arrival)) {
            $qb->andWhere('LOWER(r.arrivalTown) LIKE :arrival')
               ->setParameter('arrival', '%'.mb_strtolower($search->arrival).'%');
        }

        // Filtre date (comparaison par date, attention au type DB)
        if ($search->date instanceof \DateTimeInterface) {
            // Option A : passer la DateTime directement (Doctrine sait convertir si le champ est DATE)
            $qb->andWhere('r.departureDay = :date')
               ->setParameter('date', $search->date->format('Y-m-d'));
            // Si tu préfères expliciter le type :
            // ->setParameter('date', $search->date, \Doctrine\DBAL\Types\Types::DATE_MUTABLE);
        }

        // Filtre nombre de passagers : **nécessite** que ton entité Route possède un champ
        // du type 'availableSeats' ou 'seats'. Si tu as ce champ, on le filtre ainsi :
        if (!empty($search->passengers)) {
            // Si ton entité AppRoute a 'availableSeats' (integer)
            $qb->andWhere('r.availableSeats >= :passengers')
               ->setParameter('passengers', $search->passengers);
        }

        // Tri pratique
        $qb->orderBy('r.departureDay', 'ASC')
           ->addOrderBy('r.departureTime', 'ASC');

        $routes = $qb->getQuery()->getResult();

        return $this->render('covoiturage/index.html.twig', [
            'form'   => $form->createView(), 
            'routes' => $routes,
        ]);
    }
}
