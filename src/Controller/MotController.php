<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MotController extends AbstractController
{
    #[Route('/mot', name: 'app_mot')]
    public function index(): Response
    {
        return $this->render('mot/index.html.twig', [
            'controller_name' => 'MotController',
        ]);
    }
}
