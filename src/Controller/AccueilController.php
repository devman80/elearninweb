<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class AccueilController extends AbstractController
{
    #[Route('/admin123', name: 'app_accueil')]
    public function index(InscriptionRepository $inscriptionRepository): Response
    {
      $liste =  $inscriptionRepository->getListeNbreNonInscrit();
        $nbre = count($liste);
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'nbre'=>$nbre,
        ]);
    }
}
