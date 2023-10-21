<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\Section;
use App\Form\PaiementType;
use App\Repository\InscriptionRepository;
use App\Repository\PaiementRepository;
use App\Repository\SectionRepository;
use App\Repository\UserRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/paiement')]
class PaiementController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_paiement_index', methods: ['GET'])]
    public function indexInscrit(InscriptionRepository $inscriptionRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $inscription = $inscriptionRepository->findBy(["deletedAt" => NULL]);
        return $this->render('paiement/index.html.twig', [
                    'paiements' => $inscription,
        ]);
    }

    #[Route('/details', name: 'app_paiement_index2', methods: ['GET'])]
    public function indexPaiment(PaiementRepository $paiementRepository): Response {
        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('paiement/index2.html.twig', [
                    'paiements' => $paiementRepository->findBy($liste, ["datepaiement" => "ASC"]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_paiement_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_paiement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InscriptionRepository $inscriptionRepos,
                        PaiementRepository $paiementRepository,SectionRepository $sectionRepository,
                        UserRepository $userRepository,
                        EntityManagerInterface $entityManager, ?Paiement $paiement = null): Response {
        $user = $this->getUser();
        $type = $paiement === null ? 'new' : 'edit';
        $paiement = $paiement === null ? new Paiement() : $paiement;
        $form = $this->createForm(PaiementType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $sections = $sectionRepository->find($data["section"]->getId());
            $reste = $data["restepaie"] - $data["montantpaiement"];
            $auditeur = $inscriptionRepos->find($data["inscrit"]);

            //Modification du champ isVerified
            $userAuditeur = $auditeur->getCreatedBy();
            $usersearch = $userRepository->findOneBy(["id" =>$userAuditeur]);
            $listeUser = $userRepository->find($usersearch);
            $listeUser->setIsVerified(true);


            //Modification du reste de la scolarite

            $auditeur->setRestepaye($reste);
            $entityManager->flush();
          //  $etudiant = $inscriptionRepos->find($data[""])


            if ($type === 'new') {
                $paiement->setRestepaie($reste);
                $paiement->setMontantpaiement($data["montantpaiement"]);
                $paiement->setDatepaiement($data["datepaiement"]);
                $paiement->setSection($sections);
                $paiement->setModepaiement($data["modepaiement"]);
                $paiement->setCreatedFromIp($this->GetIp());
                $paiement->setCreatedBy($user);
                $paiement->setCreatedAt(new \DateTimeImmutable("now"));
                $paiement->setRestepaie($reste);
                $paiement->setInscription($auditeur);
                $paiementRepository->save($paiement, true);
              //  $this->addFlash('message', 'Enregistrement avec succès.');
            } else {
                $paiement->setRestepaie($reste);
                $paiement->setMontantpaiement($data["montantpaiement"]);
                $paiement->setDatepaiement($data["datepaiement"]);
                $paiement->setSection($sections);
                $paiement->setModepaiement($data["modepaiement"]);
                $paiement->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $paiement->setUpdatedBy($user);
                $paiement->setUpdatedAt(new \DateTimeImmutable("now"));
                $paiement->setRestepaie($reste);
                $paiement->setInscription($auditeur);
                $paiementRepository->save($paiement, true);
             //   $this->addFlash('message', 'Modification effectuée avec succès.');
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_paiement_new' : 'app_paiement_index';
            if ($nextAction) {
                $this->addFlash('message', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [], Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('paiement/new.html.twig', [
                    'paiement' => $paiement,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paiement_show', methods: ['GET'])]
    public function show(Paiement $paiement): Response {
        return $this->render('paiement/show.html.twig', [
                    'paiement' => $paiement,
        ]);
    }

    //   #[Route('/{id}/edit', name: 'app_paiement_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Paiement $paiement, PaiementRepository $paiementRepository): Response
    //{
    //  $form = $this->createForm(PaiementType::class, $paiement);
    //$form->handleRequest($request);
    // if ($form->isSubmitted() && $form->isValid()) {
    //   $paiementRepository->save($paiement, true);
    //    return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
    // }
    // return $this->render('paiement/edit.html.twig', [
    //     'paiement' => $paiement,
    //     'form' => $form,
    // ]);
    //  }
//if ($this->isCsrfTokenValid('delete'.$paiement->getId(), $request->request->get('_token'))) {
//$paiementRepository->remove($paiement, true);
//}

    #[Route('/delete', name: 'app_paiement_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, PaiementRepository $paiementRepository, EntityManagerInterface $entityManager): Response {
        $id = $request->request->get('delete_value');
        $LigneUpdate = $paiementRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
        $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data" => "Suppression effectuée avec succès"], 200, ["Content-type" => "application-json"]);
        // return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/filtre', name: 'app_filtre', methods: ['POST'])]
    public function getListeStagiaire(Request $request,InscriptionRepository $inscriptionRepository)
    {
        $id = $request->request->get('id');
        $restepaie = $inscriptionRepository->find($id);

        return new JsonResponse(['code'=>$restepaie->getRestepaye()],200,['Content-Type'=>'application/json']);
    }


    #[Route('/filtreinscription', name: 'app_filtre_inscription', methods: ['POST'])]
    public function getListeInscription(Request $request,InscriptionRepository $inscriptionRepository)
    {
        $id = $request->request->get('id');
        $liste = $inscriptionRepository->findBy(["section"=>$id]);
        $tab = [];
        foreach ($liste as $row){
            array_push($tab,["id"=>$row->getId(),"libelle"=>$row->getCode()."=>".$row->getNom()." ".$row->getPrenom()]);
        }

        return new JsonResponse($tab,200,['Content-Type'=>'application/json']);
    }

   #[Route('/ajout', name: 'app_paiement_ajout', methods: ['POST','GET'])]
   public function ajoutPaiement(Request $request,SectionRepository $sectionRepository){
        $section = $sectionRepository->findAll();
        return $this->render("paiement/new.html.twig",["section"=>$section]);
   }

}
