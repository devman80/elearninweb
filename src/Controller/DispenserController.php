<?php

namespace App\Controller;

use App\Entity\Dispenser;
use App\Form\DispenserprepaType;
use App\Form\DispenserType;
use App\Repository\DispenserRepository;
use App\Service\FileUploader;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dispenser')]
class DispenserController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_dispenser_index', methods: ['GET'])]
    public function index(DispenserRepository $dispenserRepository): Response {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $liste = ["deletedAt" => Null, "type" =>1];
        $limit = 1000;
        return $this->render('dispenser/index.html.twig', [
                    'dispensers' => $dispenserRepository->findBy($liste, ["id" => "ASC"]),
        ]);
    }
    
       #[Route('/prepa', name: 'app_dispenser_prepa', methods: ['GET'])]
    public function indexPrepa(DispenserRepository $dispenserRepository): Response {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $liste = ["deletedAt" => Null, "type" =>0];
        $limit = 1000;
        return $this->render('dispenser/prepa.html.twig', [
                    'dispensers' => $dispenserRepository->findBy($liste, ["id" => "ASC"]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dispenser_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_dispenser_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DispenserRepository $dispenserRepository,
            FileUploader $fileUploader, ?Dispenser $dispenser = null): Response {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $type = $dispenser === null ? 'new' : 'edit';
        $dispenser = $dispenser === null ? new Dispenser() : $dispenser;
                $user = $this->getUser();
        $form = $this->createForm(DispenserType::class, $dispenser,);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Adresse ip de l'utilisateur

            $dispenser->setCreatedFromIp($this->GetIp());

            $brochureFile = $form['brochureFilename']->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
            }
            if ($type === 'new') {
                $user = $this->getUser();

                $dispenser->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
                     $dispenser->setCreatedBy($user)
                             

                ;
                     $dispenser->setType(1);
                $dispenser->setCreatedAt(new \DateTimeImmutable("now"));
            } else {

                $dispenser->setUpdatedFromIp($this->GetIp()) ;// remplacement de la function par le trait
                        $dispenser->setUpdatedBy($user)
                ;
                
                        $dispenser->setUpdatedAt(new \DateTimeImmutable("now"));

            }

            $dispenser->setBrochureFilename($brochureFileName);
            $dispenserRepository->save($dispenser, true);

            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_dispenser_new' : 'app_dispenser_index';
            if ($nextAction) {
                $this->addFlash('message', 'Action effcetuée avec succès.');
            }

            return $this->redirectToRoute($nextAction);
//            return $this->redirectToRoute('app_seancezone_index', [], Response::HTTP_SEE_OTHER);
        }
        $response = new Response(null, $form->isSubmitted() ? 422 : 200);
        return $this->render('dispenser/new.html.twig', [
                    'dispenser' => $dispenser,
                    'form' => $form->createView(),
                    'response' => $response,
                        ], $response);
    }

    
    
    
    
     #[Route('/{id}/editprepa', name: 'app_dispenser_editprepa', methods: ['GET', 'POST'])]
    #[Route('/newprepa', name: 'app_dispenser_newprepa', methods: ['GET', 'POST'])]
    public function newPrepa(Request $request, DispenserRepository $dispenserRepository,
            FileUploader $fileUploader, ?Dispenser $dispenser = null): Response {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $type = $dispenser === null ? 'newprepa' : 'editprepa';
        $dispenser = $dispenser === null ? new Dispenser() : $dispenser;
                $user = $this->getUser();
        $form = $this->createForm(DispenserprepaType::class, $dispenser,);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Adresse ip de l'utilisateur

            $dispenser->setCreatedFromIp($this->GetIp());

            $brochureFile = $form['brochureFilename']->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
            }
            if ($type === 'newprepa') {
                $user = $this->getUser();

                $dispenser->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
                     $dispenser->setCreatedBy($user)

                ;
                     $dispenser->setType(0);
                $dispenser->setCreatedAt(new \DateTimeImmutable("now"));
            } else {

                $dispenser->setUpdatedFromIp($this->GetIp()) ;// remplacement de la function par le trait
                        $dispenser->setUpdatedBy($user)
                ;
                
                        $dispenser->setUpdatedAt(new \DateTimeImmutable("now"));

            }

            $dispenser->setBrochureFilename($brochureFileName);
            $dispenserRepository->save($dispenser, true);

            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_dispenser_newprepa' : 'app_dispenser_prepa';
            if ($nextAction) {
                $this->addFlash('message', 'Action effcetuée avec succès.');
            }

            return $this->redirectToRoute($nextAction);
//            return $this->redirectToRoute('app_seancezone_index', [], Response::HTTP_SEE_OTHER);
        }
        $response = new Response(null, $form->isSubmitted() ? 422 : 200);
        return $this->render('dispenser/newprepa.html.twig', [
                    'dispenser' => $dispenser,
                    'form' => $form->createView(),
                    'response' => $response,
                        ], $response);
    }

    
    
    
    
    
    #[Route('/{id}', name: 'app_dispenser_show', methods: ['GET'])]
    public function show(Dispenser $dispenser): Response {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('dispenser/show.html.twig', [
                    'dispenser' => $dispenser,
        ]);
    }

//    #[Route('/{id}/edit', name: 'app_dispenser_edit', methods: ['GET', 'POST'])]
//    public function edit(Request $request, Dispenser $dispenser, DispenserRepository $dispenserRepository): Response {
//        $form = $this->createForm(DispenserType::class, $dispenser);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $dispenserRepository->save($dispenser, true);
//
//            return $this->redirectToRoute('app_dispenser_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('dispenser/edit.html.twig', [
//                    'dispenser' => $dispenser,
//                    'form' => $form,
//        ]);
//    }

    #[Route('/delete', name: 'app_dispenser_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, DispenserRepository $dispenserRepository, EntityManagerInterface $entityManager): Response {
               $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $id = $request->request->get('delete_value');
        $LigneUpdate = $dispenserRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
          $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data" => "Suppression effectuée avec succès"], 200, ["Content-type" => "application-json"]);
        // return $this->redirectToRoute('app_dispenser_index', [], Response::HTTP_SEE_OTHER);
    }

}
