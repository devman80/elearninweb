<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use App\Traits\ClientIp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/module')]
class ModuleController extends AbstractController
{
    use ClientIp;

    #[Route('/', name: 'app_module_index', methods: ['GET'])]
    public function index(ModuleRepository $moduleRepository): Response
    {
        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('module/index.html.twig', [
            'modules' => $moduleRepository->findBy($liste,["libelle"=>"ASC"]),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_module_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_module_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ModuleRepository $moduleRepository, ?Module $module = null): Response
    {
        $type = $module === null ? 'new' : 'edit';
        $module = $module === null ? new Module() : $module;
        $user = $this->getUser();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $module->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
              //  ->setCreatedBy($user);
              $module->setCreatedAt(new \DateTimeImmutable("now"));

                $moduleRepository->save($module, true);

                ;
            } else {
                $module->setUpdatedFromIp($this->GetIp()) // remplacement de la function par le trait
              //  ->setUpdatedBy($user)
        ;
        $module->setUpdatedAt(new \DateTimeImmutable("now"));

                $moduleRepository->save($module, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_module_new' : 'app_module_index';
            if ($nextAction) {
                $this->addFlash('module', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [],Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('module/new.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_module_show', methods: ['GET'])]
    public function show(Module $module): Response
    {
        return $this->render('module/show.html.twig', [
            'module' => $module,
        ]);
    }

 //   #[Route('/{id}/edit', name: 'app_module_edit', methods: ['GET', 'POST'])]
   // public function edit(Request $request, Module $module, ModuleRepository $moduleRepository): Response
    //{
      //  $form = $this->createForm(ModuleType::class, $module);
        //$form->handleRequest($request);

       // if ($form->isSubmitted() && $form->isValid()) {
         //   $moduleRepository->save($module, true);

        //    return $this->redirectToRoute('app_module_index', [], Response::HTTP_SEE_OTHER);
       // }

       // return $this->render('module/edit.html.twig', [
       //     'module' => $module,
       //     'form' => $form,
       // ]);
  //  }
//if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->request->get('_token'))) {
//$moduleRepository->remove($module, true);
//}

    #[Route('/delete', name: 'app_module_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request,ModuleRepository $moduleRepository, EntityManagerInterface $entityManager): Response
    {
        $id = $request->request->get('delete_value');
        $LigneUpdate = $moduleRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
      //  $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data"=>"Suppression effectuée avec succès"],200,["Content-type"=>"application-json"]);
      // return $this->redirectToRoute('app_module_index', [], Response::HTTP_SEE_OTHER);
    }

}
