<?php

namespace App\Controller;

use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/section')]
class SectionController extends AbstractController
{
    use ClientIp;

    #[Route('/', name: 'app_section_index', methods: ['GET'])]
    public function index(SectionRepository $sectionRepository): Response
    {
        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('section/index.html.twig', [
            'sections' => $sectionRepository->findBy($liste,["libelle"=>"ASC"]),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_section_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_section_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SectionRepository $sectionRepository, ?Section $section = null): Response
    {
        $type = $section === null ? 'new' : 'edit';
        $section = $section === null ? new Section() : $section;
        $user = $this->getUser();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $section->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
              //  ->setCreatedBy($user);
              $section->setCreatedAt(new \DateTimeImmutable("now"));

                $sectionRepository->save($section, true);

                ;
            } else {
                $section->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
              //  ->setUpdatedBy($user)
              $section->setUpdatedAt(new \DateTimeImmutable("now"));


        
                $sectionRepository->save($section, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_section_new' : 'app_section_index';
            if ($nextAction) {
                $this->addFlash('section', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [],Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('section/new.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_section_show', methods: ['GET'])]
    public function show(Section $section): Response
    {
        return $this->render('section/show.html.twig', [
            'section' => $section,
        ]);
    }

 //   #[Route('/{id}/edit', name: 'app_section_edit', methods: ['GET', 'POST'])]
   // public function edit(Request $request, Section $section, SectionRepository $sectionRepository): Response
    //{
      //  $form = $this->createForm(SectionType::class, $section);
        //$form->handleRequest($request);

       // if ($form->isSubmitted() && $form->isValid()) {
         //   $sectionRepository->save($section, true);

        //    return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
       // }

       // return $this->render('section/edit.html.twig', [
       //     'section' => $section,
       //     'form' => $form,
       // ]);
  //  }
//if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
//$sectionRepository->remove($section, true);
//}

    #[Route('/delete', name: 'app_section_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request,SectionRepository $sectionRepository, EntityManagerInterface $entityManager): Response
    {
        $id = $request->request->get('delete_value');
        $LigneUpdate = $sectionRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
      //  $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data"=>"Suppression effectuée avec succès"],200,["Content-type"=>"application-json"]);
      // return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
    }

}
