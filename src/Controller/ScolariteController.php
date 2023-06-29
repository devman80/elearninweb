<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScolariteController extends AbstractController
{
    #[Route('/scolarite', name: 'app_scolarite')]
    public function index(): Response
    {
        return $this->render('scolarite/index.html.twig', [
            'controller_name' => 'ScolariteController',
        ]);
    }
}
