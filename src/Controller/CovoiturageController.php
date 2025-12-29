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
        $form = $this->createForm(SearchRideFormType::class, $search, ['method' => 'GET']);
        $form->handleRequest($request);

        // $connection = $em->getConnection();
        // try {
        //     $connection->connect();
        //     dump('Connexion OK');
        // } catch (\Exception $e) {
        //     dump('Erreur connexion : ' . $e->getMessage());
        // }
        // die;

        $qb = $em->getRepository(AppRoute::class)->createQueryBuilder('r');

        // --- Recherche par champ du formulaire ---
        if (!empty($search->departure)) {
            $qb->andWhere('LOWER(r.departureTown) LIKE :departure')
                ->setParameter('departure', '%' . mb_strtolower($search->departure) . '%');
        }

        if (!empty($search->arrival)) {
            $qb->andWhere('LOWER(r.arrivalTown) LIKE :arrival')
                ->setParameter('arrival', '%' . mb_strtolower($search->arrival) . '%');
        }

        if ($search->date instanceof \DateTimeInterface) {
            $qb->andWhere('r.departureDay = :date')
                ->setParameter('date', $search->date->format('Y-m-d'));
        }

        if (!empty($search->passengers)) {
            $qb->andWhere('r.availableSeats >= :passengers')
                ->setParameter('passengers', $search->passengers);
        }

        // --- Recherche rapide via ?q= ---
        if ($request->query->has('q')) {
            $q = mb_strtolower($request->query->get('q'));
            $qb->andWhere('LOWER(r.departureTown) LIKE :q OR LOWER(r.arrivalTown) LIKE :q')
                ->setParameter('q', "%$q%");
        }

        // --- Tri par date et heure ---
        $qb->orderBy('r.departureDay', 'ASC')
            ->addOrderBy('r.departureTime', 'ASC');

        $routes = $qb->getQuery()->getResult();

        return $this->render('covoiturage/index.html.twig', [
            'form' => $form->createView(),
            'routes' => $routes,
        ]);
    }
}
// Dans ton contrôleur
// dump($_ENV['DATABASE_URL'] ?? 'ENV NOT SET');
// dump($_SERVER['DATABASE_URL'] ?? 'SERVER NOT SET');
// die('STOP DB DEBUG');
