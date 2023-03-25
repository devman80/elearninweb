<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use App\Traits\ClientIp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/module')]
class ModuleController extends AbstractController
{
    use ClientIp;

    #[Route('/', name: 'app_module_index', methods: ['GET'])]
    public function index(ModuleRepository $moduleRepository): Response
    {
        return $this->render('module/index.html.twig', [
            'modules' => $moduleRepository->findAll(),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_module_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_module_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ModuleRepository $moduleRepository, ?Module $module = null): Response
    {
        $type = $module === null ? 'new' : 'edit';
        $module = $module === null ? new Module() : $module;
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {
                $moduleRepository->save($module, true);

                ;
            } else {
                $moduleRepository->save($module, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_module_new' : 'app_module_index';
            if ($nextAction) {
                $this->addFlash('module', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction);
        }

        $response = new Response(null, $form->isSubmitted() ? 422 : 200);

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

    #[Route('/{id}', name: 'app_module_delete', methods: ['POST'])]
    public function delete(Request $request, Module $module, ModuleRepository $moduleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->request->get('_token'))) {
            $moduleRepository->remove($module, true);
        }

        return $this->redirectToRoute('app_module_index', [], Response::HTTP_SEE_OTHER);
    }
}
