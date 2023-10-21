<?php

namespace App\Controller;

use App\Entity\Versement;
use App\Form\VersementType;
use App\Repository\VersementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/versement')]
class VersementController extends AbstractController
{
    #[Route('/', name: 'app_versement_index', methods: ['GET'])]
    public function index(VersementRepository $versementRepository): Response
    {
            if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        return $this->render('versement/index.html.twig', [
            'versements' => $versementRepository->findAll(),
        ]);
    }

     #[Route('/{id}/edit', name: 'app_versement_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_versement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VersementRepository $versementRepository, ?Versement $versement = null): Response
    {
 if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        $type = $versement === null ? 'new' : 'edit';
        $versement = $versement === null ? new Versement() : $versement;
        $user = $this->getUser();
        $form = $this->createForm(VersementType::class, $versement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $versement->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
             

                $versementRepository->save($versement, true);

                
            } else {
        ;

                $versementRepository->save($versement, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_versement_new' : 'app_versement_index';
            if ($nextAction) {
                $this->addFlash('versement', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [],Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('versement/new.html.twig', [
            'versement' => $versement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_versement_show', methods: ['GET'])]
    public function show(Versement $versement): Response
    {
            if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        return $this->render('versement/show.html.twig', [
            'versement' => $versement,
        ]);
    }
//
//    #[Route('/{id}/edit', name: 'app_versement_edit', methods: ['GET', 'POST'])]
//    public function edit(Request $request, Versement $versement, VersementRepository $versementRepository): Response
//    {
//            if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
//            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
//        }
//        $form = $this->createForm(VersementType::class, $versement);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $versementRepository->save($versement, true);
//
//            return $this->redirectToRoute('app_versement_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('versement/edit.html.twig', [
//            'versement' => $versement,
//            'form' => $form,
//        ]);
//    }

    #[Route('/{id}', name: 'app_versement_delete', methods: ['POST'])]
    public function delete(Request $request, Versement $versement, VersementRepository $versementRepository): Response
    {
            if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        if ($this->isCsrfTokenValid('delete'.$versement->getId(), $request->request->get('_token'))) {
            $versementRepository->remove($versement, true);
        }

        return $this->redirectToRoute('app_versement_index', [], Response::HTTP_SEE_OTHER);
    }
}
