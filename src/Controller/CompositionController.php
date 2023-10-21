<?php

namespace App\Controller;

use App\Entity\Composition;
use App\Entity\Option;
use App\Form\CompositionType;
use App\Repository\CompositionRepository;
use App\Repository\OptionRepository;
use App\Traits\ClientIp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/composition')]
class CompositionController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_composition_index', methods: ['GET'])]
    public function index(CompositionRepository $compositionRepository): Response {
        return $this->render('composition/index.html.twig', [
                    'compositions' => $compositionRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_composition_edit', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_composition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompositionRepository $compositionRepository, OptionRepository $optionRepo, ?Composition $composition = null): Response {
        $user = $this->getUser();
        $type = $composition === null ? 'new' : 'edit';
        $composition = $composition === null ? new Composition() : $composition;

        $form = $this->createForm(CompositionType::class, $composition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($type === 'new') {


                $option = new Option();

                $option->setCreatedFromIp($this->GetIp());
                $option->setCreatedBy($user);
                $option->setComposition($composition);

                $composition->setCreatedFromIp($this->GetIp());
                $composition->setCreatedBy($user);
                $composition->setCreatedAt(new \DateTimeImmutable("now"));

                $compositionRepository->save($composition, true);
                $optionRepo->save($option, true);
            } else {
                $composition->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                $composition->setUpdatedBy($user)
                ;
                $composition->setUpdatedAt(new \DateTimeImmutable("now"));

                $compositionRepository->save($composition, true);
            }
            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_composition_new' : 'app_composition_index';
            if ($nextAction) {
                $this->addFlash('composition', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction, [], Response::HTTP_SEE_OTHER);
        }

        $response = new Response(null, $form->isSubmitted() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK);

        return $this->render('composition/new.html.twig', [
                    'composition' => $composition,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_composition_show', methods: ['GET'])]
    public function show(Composition $composition): Response {
        return $this->render('composition/show.html.twig', [
                    'composition' => $composition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_composition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Composition $composition, CompositionRepository $compositionRepository): Response {
        $form = $this->createForm(CompositionType::class, $composition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compositionRepository->save($composition, true);

            return $this->redirectToRoute('app_composition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('composition/edit.html.twig', [
                    'composition' => $composition,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_composition_delete', methods: ['POST'])]
    public function delete(Request $request, Composition $composition, CompositionRepository $compositionRepository): Response {
        if ($this->isCsrfTokenValid('delete' . $composition->getId(), $request->request->get('_token'))) {
            $compositionRepository->remove($composition, true);
        }

        return $this->redirectToRoute('app_composition_index', [], Response::HTTP_SEE_OTHER);
    }

}
