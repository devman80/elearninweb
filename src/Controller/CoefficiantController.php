<?php

namespace App\Controller;

use App\Entity\Coefficiant;
use App\Form\CoefficiantType;
use App\Repository\CoefficiantRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/coefficiant')]
class CoefficiantController extends AbstractController
{
    use ClientIp;

    #[Route('/', name: 'app_coefficiant_index', methods: ['GET'])]
    public function index(CoefficiantRepository $coefficiantRepository): Response
    {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('coefficiant/index.html.twig', [
            'coefficiants' => $coefficiantRepository->findBy($liste,["libelle"=>"ASC"]),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_coefficiant_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_coefficiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CoefficiantRepository $coefficiantRepository, ?Coefficiant $coefficiant = null): Response
    {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $type = $coefficiant === null ? 'new' : 'edit';
        $coefficiant = $coefficiant === null ? new Coefficiant() : $coefficiant;
        $user = $this->getUser();
        $form = $this->createForm(CoefficiantType::class, $coefficiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $coefficiant->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $coefficiant->setCreatedBy($user);
              $coefficiant->setCreatedAt(new \DateTimeImmutable("now"));
                $coefficiantRepository->save($coefficiant, true);

                
            } else {
                $coefficiant->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $coefficiant->setUpdatedBy($user);
              $coefficiant->setUpdatedAt(new \DateTimeImmutable("now"));


        
                $coefficiantRepository->save($coefficiant, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_coefficiant_new' : 'app_coefficiant_index';
            if ($nextAction) {
                $this->addFlash('coefficiant', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [],Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('coefficiant/new.html.twig', [
            'coefficiant' => $coefficiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coefficiant_show', methods: ['GET'])]
    public function show(Coefficiant $coefficiant): Response
    {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('coefficiant/show.html.twig', [
            'coefficiant' => $coefficiant,
        ]);
    }

 //   #[Route('/{id}/edit', name: 'app_coefficiant_edit', methods: ['GET', 'POST'])]
   // public function edit(Request $request, Coefficiant $coefficiant, CoefficiantRepository $coefficiantRepository): Response
    //{
      //  $form = $this->createForm(CoefficiantType::class, $coefficiant);
        //$form->handleRequest($request);

       // if ($form->isSubmitted() && $form->isValid()) {
         //   $coefficiantRepository->save($coefficiant, true);

        //    return $this->redirectToRoute('app_coefficiant_index', [], Response::HTTP_SEE_OTHER);
       // }

       // return $this->render('coefficiant/edit.html.twig', [
       //     'coefficiant' => $coefficiant,
       //     'form' => $form,
       // ]);
  //  }
//if ($this->isCsrfTokenValid('delete'.$coefficiant->getId(), $request->request->get('_token'))) {
//$coefficiantRepository->remove($coefficiant, true);
//}

    #[Route('/delete', name: 'app_coefficiant_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request,CoefficiantRepository $coefficiantRepository, EntityManagerInterface $entityManager): Response
    {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $id = $request->request->get('delete_value');
        $LigneUpdate = $coefficiantRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
        $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data"=>"Suppression effectuée avec succès"],200,["Content-type"=>"application-json"]);
      // return $this->redirectToRoute('app_coefficiant_index', [], Response::HTTP_SEE_OTHER);
    }

}
