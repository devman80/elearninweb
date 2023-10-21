<?php

namespace App\Controller;

use App\Entity\Depense;
use App\Form\DepenseType;
use App\Repository\DepenseRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/depense')]
class DepenseController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_depense_index', methods: ['GET'])]
    public function index(DepenseRepository $depenseRepository): Response {
        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('depense/index.html.twig', [
                    'depenses' => $depenseRepository->findBy($liste, ["objet" => "ASC"]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_depense_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_depense_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DepenseRepository $depenseRepository, ?Depense $depense = null): Response {
        $user = $this->getUser();
        $type = $depense === null ? 'new' : 'edit';
        $depense = $depense === null ? new Depense() : $depense;

        $form = $this->createForm(DepenseType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $depense->setCreatedFromIp($this->GetIp());
                $depense->setCreatedBy($user);
                $depense->setCreatedAt(new \DateTimeImmutable("now"));

                $depenseRepository->save($depense, true);
                $this->addFlash('message', 'Enregistrement avec succès.');
            } else {
                $depense->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $depense->setUpdatedBy($user)
                ;
                $depense->setUpdatedAt(new \DateTimeImmutable("now"));

                $depenseRepository->save($depense, true);
                $this->addFlash('message', 'Modification effectuée avec succès.');
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_depense_new' : 'app_depense_index';
            if ($nextAction) {
                
            }

            return $this->redirectToRoute($nextAction, [], Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('depense/new.html.twig', [
                    'depense' => $depense,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depense_show', methods: ['GET'])]
    public function show(Depense $depense): Response {
        return $this->render('depense/show.html.twig', [
                    'depense' => $depense,
        ]);
    }

    //   #[Route('/{id}/edit', name: 'app_depense_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Depense $depense, DepenseRepository $depenseRepository): Response
    //{
    //  $form = $this->createForm(DepenseType::class, $depense);
    //$form->handleRequest($request);
    // if ($form->isSubmitted() && $form->isValid()) {
    //   $depenseRepository->save($depense, true);
    //    return $this->redirectToRoute('app_depense_index', [], Response::HTTP_SEE_OTHER);
    // }
    // return $this->render('depense/edit.html.twig', [
    //     'depense' => $depense,
    //     'form' => $form,
    // ]);
    //  }
//if ($this->isCsrfTokenValid('delete'.$depense->getId(), $request->request->get('_token'))) {
//$depenseRepository->remove($depense, true);
//}

    #[Route('/delete', name: 'app_depense_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, DepenseRepository $depenseRepository, EntityManagerInterface $entityManager): Response {
        $id = $request->request->get('delete_value');
        $LigneUpdate = $depenseRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
        $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data" => "Suppression effectuée avec succès"], 200, ["Content-type" => "application-json"]);
        // return $this->redirectToRoute('app_depense_index', [], Response::HTTP_SEE_OTHER);
    }

}
