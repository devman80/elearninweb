<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Session1Controller extends AbstractController
{
    #[Route('/session1', name: 'app_session1')]
    public function index(): Response
    {
        return $this->render('session1/index.html.twig', [
            'controller_name' => 'Session1Controller',
        ]);
    }
}
