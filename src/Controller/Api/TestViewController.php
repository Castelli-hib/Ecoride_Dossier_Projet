<?php
// src/Controller/Api/TestViewController.php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestViewController extends AbstractController
{
    #[Route('/test/routes', name: 'test_routes')]
    public function index(): Response
    {
        // Rend la vue Twig qui fera le fetch de l'API
        return $this->render('api/routes_test.html.twig');
    }
}
