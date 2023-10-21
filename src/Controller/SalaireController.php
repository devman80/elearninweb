<?php

namespace App\Controller;

use App\Entity\Salaire;
use App\Form\SalaireType;
use App\Repository\SalaireRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/salaire')]
class SalaireController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_salaire_index', methods: ['GET'])]
    public function index(SalaireRepository $salaireRepository): Response {
        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('salaire/index.html.twig', [
                    'salaires' => $salaireRepository->findBy($liste, ["datesalaire" => "ASC"]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_salaire_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_salaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SalaireRepository $salaireRepository, ?Salaire $salaire = null): Response {
        $user = $this->getUser();
        $type = $salaire === null ? 'new' : 'edit';
        $salaire = $salaire === null ? new Salaire() : $salaire;

        $form = $this->createForm(SalaireType::class, $salaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $salaire->setCreatedFromIp($this->GetIp());
                $salaire->setCreatedBy($user);
                $salaire->setCreatedAt(new \DateTimeImmutable("now"));

                $salaireRepository->save($salaire, true);
                $this->addFlash('message', 'Enregistrement avec succès.');
            } else {
                $salaire->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $salaire->setUpdatedBy($user)
                ;
                $salaire->setUpdatedAt(new \DateTimeImmutable("now"));

                $salaireRepository->save($salaire, true);
                $this->addFlash('message', 'Modification effectuée avec succès.');
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_salaire_new' : 'app_salaire_index';
            if ($nextAction) {
                
            }

            return $this->redirectToRoute($nextAction, [], Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('salaire/new.html.twig', [
                    'salaire' => $salaire,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salaire_show', methods: ['GET'])]
    public function show(Salaire $salaire): Response {
        return $this->render('salaire/show.html.twig', [
                    'salaire' => $salaire,
        ]);
    }

    //   #[Route('/{id}/edit', name: 'app_salaire_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Salaire $salaire, SalaireRepository $salaireRepository): Response
    //{
    //  $form = $this->createForm(SalaireType::class, $salaire);
    //$form->handleRequest($request);
    // if ($form->isSubmitted() && $form->isValid()) {
    //   $salaireRepository->save($salaire, true);
    //    return $this->redirectToRoute('app_salaire_index', [], Response::HTTP_SEE_OTHER);
    // }
    // return $this->render('salaire/edit.html.twig', [
    //     'salaire' => $salaire,
    //     'form' => $form,
    // ]);
    //  }
//if ($this->isCsrfTokenValid('delete'.$salaire->getId(), $request->request->get('_token'))) {
//$salaireRepository->remove($salaire, true);
//}

    #[Route('/delete', name: 'app_salaire_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, SalaireRepository $salaireRepository, EntityManagerInterface $entityManager): Response {
        $id = $request->request->get('delete_value');
        $LigneUpdate = $salaireRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
        $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data" => "Suppression effectuée avec succès"], 200, ["Content-type" => "application-json"]);
        // return $this->redirectToRoute('app_salaire_index', [], Response::HTTP_SEE_OTHER);
    }

}
