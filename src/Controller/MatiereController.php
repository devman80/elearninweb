<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/matiere')]
class MatiereController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_matiere_index', methods: ['GET'])]
    public function index(MatiereRepository $matiereRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('matiere/index.html.twig', [
                    'matieres' => $matiereRepository->findBy($liste, ["libelle" => "ASC"]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_matiere_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_matiere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MatiereRepository $matiereRepository, ?Matiere $matiere = null): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $type = $matiere === null ? 'new' : 'edit';
        $matiere = $matiere === null ? new Matiere() : $matiere;
        $user = $this->getUser();
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $matiere->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
                  $matiere->setCreatedBy($user);
                $matiere->setCreatedAt(new \DateTimeImmutable("now"));

                $matiereRepository->save($matiere, true);

                
            } else {
                $matiere->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                  $matiere->setUpdatedBy($user);
                $matiere->setUpdatedAt(new \DateTimeImmutable("now"));

                $matiereRepository->save($matiere, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_matiere_new' : 'app_matiere_index';
            if ($nextAction) {
                $this->addFlash('matiere', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [], Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('matiere/new.html.twig', [
                    'matiere' => $matiere,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_matiere_show', methods: ['GET'])]
    public function show(Matiere $matiere): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('matiere/show.html.twig', [
                    'matiere' => $matiere,
        ]);
    }

    //   #[Route('/{id}/edit', name: 'app_matiere_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Matiere $matiere, MatiereRepository $matiereRepository): Response
    //{
    //  $form = $this->createForm(MatiereType::class, $matiere);
    //$form->handleRequest($request);
    // if ($form->isSubmitted() && $form->isValid()) {
    //   $matiereRepository->save($matiere, true);
    //    return $this->redirectToRoute('app_matiere_index', [], Response::HTTP_SEE_OTHER);
    // }
    // return $this->render('matiere/edit.html.twig', [
    //     'matiere' => $matiere,
    //     'form' => $form,
    // ]);
    //  }
//if ($this->isCsrfTokenValid('delete'.$matiere->getId(), $request->request->get('_token'))) {
//$matiereRepository->remove($matiere, true);
//}

    #[Route('/delete', name: 'app_matiere_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, MatiereRepository $matiereRepository, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $id = $request->request->get('delete_value');
        $LigneUpdate = $matiereRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
          $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data" => "Suppression effectuée avec succès"], 200, ["Content-type" => "application-json"]);
        // return $this->redirectToRoute('app_matiere_index', [], Response::HTTP_SEE_OTHER);
    }

    
    
 
    
}
