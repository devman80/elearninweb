<?php

namespace App\Controller;

use App\Entity\Inscrire;
use App\Form\InscrireType;
use App\Repository\InscrireRepository;
use App\Traits\ClientIp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inscrire')]
class InscrireController extends AbstractController
{
use  ClientIp;

    #[Route('/', name: 'app_inscrire_index', methods: ['GET'])]
    public function index(InscrireRepository $inscrireRepository): Response
    {
        return $this->render('inscrire/index.html.twig', [
            'inscrires' => $inscrireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_inscrire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InscrireRepository $inscrireRepository): Response
    {
        $inscrire = new Inscrire();
        $form = $this->createForm(InscrireType::class, $inscrire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscrireRepository->save($inscrire, true);

            return $this->redirectToRoute('app_inscrire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscrire/new.html.twig', [
            'inscrire' => $inscrire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inscrire_show', methods: ['GET'])]
    public function show(Inscrire $inscrire): Response
    {
        return $this->render('inscrire/show.html.twig', [
            'inscrire' => $inscrire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inscrire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Inscrire $inscrire, InscrireRepository $inscrireRepository): Response
    {
        $form = $this->createForm(InscrireType::class, $inscrire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscrireRepository->save($inscrire, true);

            return $this->redirectToRoute('app_inscrire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscrire/edit.html.twig', [
            'inscrire' => $inscrire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inscrire_delete', methods: ['POST'])]
    public function delete(Request $request, Inscrire $inscrire, InscrireRepository $inscrireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inscrire->getId(), $request->request->get('_token'))) {
            $inscrireRepository->remove($inscrire, true);
        }

        return $this->redirectToRoute('app_inscrire_index', [], Response::HTTP_SEE_OTHER);
    }
}
