<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Form\CommuneType;
use App\Repository\CommuneRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/commune')]
class CommuneController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_commune_index', methods: ['GET'])]
    public function index(CommuneRepository $communeRepository): Response {
        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('commune/index.html.twig', [
                    'communes' => $communeRepository->findBy($liste, ["libelle" => "ASC"]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commune_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_commune_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommuneRepository $communeRepository, ?Commune $commune = null): Response {
        $user = $this->getUser();
        $type = $commune === null ? 'new' : 'edit';
        $commune = $commune === null ? new Commune() : $commune;

        $form = $this->createForm(CommuneType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $commune->setCreatedFromIp($this->GetIp());
                $commune->setCreatedBy($user);
                $commune->setCreatedAt(new \DateTimeImmutable("now"));

                $communeRepository->save($commune, true);
            } else {
                $commune->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $commune->setUpdatedBy($user)
                ;
                $commune->setUpdatedAt(new \DateTimeImmutable("now"));

                $communeRepository->save($commune, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_commune_new' : 'app_commune_index';
            if ($nextAction) {
                $this->addFlash('commune', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [], Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('commune/new.html.twig', [
                    'commune' => $commune,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commune_show', methods: ['GET'])]
    public function show(Commune $commune): Response {
        return $this->render('commune/show.html.twig', [
                    'commune' => $commune,
        ]);
    }

    //   #[Route('/{id}/edit', name: 'app_commune_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Commune $commune, CommuneRepository $communeRepository): Response
    //{
    //  $form = $this->createForm(CommuneType::class, $commune);
    //$form->handleRequest($request);
    // if ($form->isSubmitted() && $form->isValid()) {
    //   $communeRepository->save($commune, true);
    //    return $this->redirectToRoute('app_commune_index', [], Response::HTTP_SEE_OTHER);
    // }
    // return $this->render('commune/edit.html.twig', [
    //     'commune' => $commune,
    //     'form' => $form,
    // ]);
    //  }
//if ($this->isCsrfTokenValid('delete'.$commune->getId(), $request->request->get('_token'))) {
//$communeRepository->remove($commune, true);
//}

    #[Route('/delete', name: 'app_commune_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, CommuneRepository $communeRepository, EntityManagerInterface $entityManager): Response {
        $id = $request->request->get('delete_value');
        $LigneUpdate = $communeRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
        $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data" => "Suppression effectuée avec succès"], 200, ["Content-type" => "application-json"]);
        // return $this->redirectToRoute('app_commune_index', [], Response::HTTP_SEE_OTHER);
    }

}
