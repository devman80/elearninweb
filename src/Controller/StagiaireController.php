<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use App\Traits\ClientIp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/stagiaire')]
class StagiaireController extends AbstractController
{
use ClientIp;

    #[Route('/', name: 'app_stagiaire_index', methods: ['GET'])]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        $liste = ["deletedAt" => Null];
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaireRepository->findBy($liste,["nom"=>"ASC"]),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_stagiaire_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_stagiaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StagiaireRepository $stagiaireRepository, ?Stagiaire $stagiaire=null): Response
    {

        $type = $stagiaire === null ? 'new' : 'edit';
        $stagiaire = $stagiaire === null ? new Stagiaire() : $stagiaire;
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($type === 'new') {
                $stagiaireRepository->save($stagiaire, true);

            } else {
                $stagiaireRepository->save($stagiaire, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_stagiaire_new' : 'app_stagiaire_index';
            if ($nextAction) {
                $this->addFlash('stagiaire', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [],Response::HTTP_SEE_OTHER);
        }
        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('stagiaire/new.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form,
        ]);
    }

//    #[Route('/{id}', name: 'app_stagiaire_show', methods: ['GET'])]
//    public function show(Stagiaire $stagiaire): Response
//    {
//        return $this->render('stagiaire/show.html.twig', [
//            'stagiaire' => $stagiaire,
//        ]);
//    }
//
//    #[Route('/{id}/edit', name: 'app_stagiaire_edit', methods: ['GET', 'POST'])]
//    public function edit(Request $request, Stagiaire $stagiaire, StagiaireRepository $stagiaireRepository): Response
//    {
//        $form = $this->createForm(StagiaireType::class, $stagiaire);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $stagiaireRepository->save($stagiaire, true);
//
//            return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('stagiaire/edit.html.twig', [
//            'stagiaire' => $stagiaire,
//            'form' => $form,
//        ]);
//    }

    #[Route('/delete', name: 'app_stagiaire_delete', methods: ['GET','POST'])]

    public function delete(Request $request,StagiaireRepository $stagiaireRepository, EntityManagerInterface $entityManager): Response
    {
        $id = $request->request->get('delete_value');
        $LigneUpdate = $stagiaireRepository->find($id);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data"=>"Suppression effectuée avec succès"],200,["Content-type"=>"application-json"]);
    }
}
