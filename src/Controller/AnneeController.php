<?php

namespace App\Controller;

use App\Entity\Annee;
use App\Form\AnneeType;
use App\Repository\AnneeRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/annee')]
class AnneeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager = $entityManager;
    }
    use ClientIp;

    #[Route('/', name: 'app_annee_index', methods: ['GET'])]
    public function index(AnneeRepository $anneeRepository): Response
    {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('annee/index.html.twig', [
            'annees' => $anneeRepository->findBy($liste,["libelle"=>"ASC"]),
        ]);
    }

        private function getData(): array {
        /**
         * @var $annee Annee[]
         */
        $list = [];
        $annees = $this->entityManager->getRepository(Annee::class)->findBy(['deletedAt' => NULL], ['id'=>'desc'], 1,0);

        foreach ($annees as $annee) {
            $list[] = [
                $annee->getLibelle()
            ];
        }
        return $list;
    }

    #[Route('/{id}/edit', name: 'app_annee_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_annee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnneeRepository $anneeRepository, ?Annee $annee = null): Response
    {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $type = $annee === null ? 'new' : 'edit';
        $annee = $annee === null ? new Annee() : $annee;
        $user = $this->getUser();
        $form = $this->createForm(AnneeType::class, $annee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $annee->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $annee->setCreatedBy($user);
              $annee->setCreatedAt(new \DateTimeImmutable("now"));

                $anneeRepository->save($annee, true);

                ;
            } else {
                $annee->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $annee->setUpdatedBy($user)
        ;
        $annee->setUpdatedAt(new \DateTimeImmutable("now"));

                $anneeRepository->save($annee, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_annee_new' : 'app_annee_index';
            if ($nextAction) {
                $this->addFlash('annee', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [],Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('annee/new.html.twig', [
            'annee' => $annee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_show', methods: ['GET'])]
    public function show(Annee $annee): Response
    {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('annee/show.html.twig', [
            'annee' => $annee,
        ]);
    }

 //   #[Route('/{id}/edit', name: 'app_annee_edit', methods: ['GET', 'POST'])]
   // public function edit(Request $request, Annee $annee, AnneeRepository $anneeRepository): Response
    //{
      //  $form = $this->createForm(AnneeType::class, $annee);
        //$form->handleRequest($request);

       // if ($form->isSubmitted() && $form->isValid()) {
         //   $anneeRepository->save($annee, true);

        //    return $this->redirectToRoute('app_annee_index', [], Response::HTTP_SEE_OTHER);
       // }

       // return $this->render('annee/edit.html.twig', [
       //     'annee' => $annee,
       //     'form' => $form,
       // ]);
  //  }
//if ($this->isCsrfTokenValid('delete'.$annee->getId(), $request->request->get('_token'))) {
//$anneeRepository->remove($annee, true);
//}

    #[Route('/delete', name: 'app_annee_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request,AnneeRepository $anneeRepository, EntityManagerInterface $entityManager): Response
    {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $id = $request->request->get('delete_value');
        $LigneUpdate = $anneeRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
       $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data"=>"Suppression effectuée avec succès"],200,["Content-type"=>"application-json"]);
      // return $this->redirectToRoute('app_annee_index', [], Response::HTTP_SEE_OTHER);
    }

}
