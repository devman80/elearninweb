<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Session2Controller extends AbstractController
{
    #[Route('/session2', name: 'app_session2')]
    public function index(): Response
    {
        return $this->render('session2/index.html.twig', [
            'controller_name' => 'Session2Controller',
        ]);
    }
}
