<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrepaController extends AbstractController
{
    #[Route('/prepa', name: 'app_prepa')]
    public function index(): Response
    {
        return $this->render('prepa/index.html.twig', [
            'controller_name' => 'PrepaController',
        ]);
    }
}
