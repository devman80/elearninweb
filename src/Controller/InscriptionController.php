<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Form\UpdateinscriptionType;
use App\Repository\InscriptionRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/inscription')]
class InscriptionController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_inscription_index', methods: ['GET'])]
    public function index(InscriptionRepository $inscriptionRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $inscription = $inscriptionRepository->findBy(["editable" => 1]);
        return $this->render('inscription/index.html.twig', [
                    'inscriptions' => $inscription,
        ]);
    }

    #[Route('/new', name: 'app_inscription_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InscriptionRepository $inscriptionRepository, SluggerInterface $slugger): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $inscription->setCreatedFromIp($this->GetIp());

            $lesinscriptions = $inscriptionRepository->findBy(array(), array('id' => 'desc'), 1, 0);
            $id = 0;
            foreach ($lesinscriptions as $value) {
                $id = $value->getId();
            }
            $val = $id + 1;
            $idEnfant = substr($val, 0, 4);

            $naissance = $form['datenaissance']->getData();
            $child = $form['nom']->getData();
            $conversion = $naissance->format('Y-m-d');
            $an = explode('-', $conversion);
            $nominscription = substr($child, 0, 2);
            $code = $an[0] . $nominscription . $idEnfant;
            $inscription->setCode($code);

            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $inscription->setBrochureFilename($newFilename);
            };

            $extraitFile = $form->get('extrait')->getData();
            if ($extraitFile) {
                $originalFilename2 = pathinfo($extraitFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename2 = $slugger->slug($originalFilename2);
                $newFilename2 = $safeFilename2 . '-' . uniqid() . '.' . $extraitFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $extraitFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename2
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $inscription->setExtraitFilename($newFilename2);
            }

            $certificatFile = $form->get('certificat')->getData();
            if ($certificatFile) {
                $originalFilename3 = pathinfo($certificatFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename3 = $slugger->slug($originalFilename3);
                $newFilename3 = $safeFilename3 . '-' . uniqid() . '.' . $certificatFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $extraitFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename3
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $inscription->setCertificatFilename($newFilename3);
            }



            $diplomeFile = $form->get('diplome')->getData();
            if ($diplomeFile) {
                $diplomeFilename = pathinfo($diplomeFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename1 = $slugger->slug($diplomeFilename);
                $newDiplomename = $safeFilename1 . '-' . uniqid() . '.' . $diplomeFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $diplomeFile->move(
                            $this->getParameter('brochures_directory'),
                            $newDiplomename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $inscription->setDiplomeFilename($newDiplomename);
            }


            $inscriptionRepository->save($inscription, true);

            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('inscription/new.html.twig', [
                    'inscription' => $inscription,
                    'form' => $form,
        ]);
    }

    #[Route('d/{id}', name: 'app_inscription_show', methods: ['GET', 'POST'])]
    public function show(Inscription $inscription): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('inscription/show.html.twig', [
                    'inscription' => $inscription,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inscription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Inscription $inscription, InscriptionRepository $inscriptionRepository, SluggerInterface $slugger): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $inscription->setCreatedFromIp($this->GetIp());

            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $inscription->setBrochureFilename($newFilename);
            };

            $extraitFile = $form->get('extrait')->getData();
            if ($extraitFile) {
                $originalFilename2 = pathinfo($extraitFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename2 = $slugger->slug($originalFilename2);
                $newFilename2 = $safeFilename2 . '-' . uniqid() . '.' . $extraitFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $extraitFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename2
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $inscription->setExtraitFilename($newFilename2);
            }

            $certificatFile = $form->get('certificat')->getData();
            if ($certificatFile) {
                $originalFilename3 = pathinfo($certificatFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename3 = $slugger->slug($originalFilename3);
                $newFilename3 = $safeFilename3 . '-' . uniqid() . '.' . $certificatFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $extraitFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename3
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $inscription->setCertificatFilename($newFilename3);
            }



            $diplomeFile = $form->get('diplome')->getData();
            if ($diplomeFile) {
                $diplomeFilename = pathinfo($diplomeFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename1 = $slugger->slug($diplomeFilename);
                $newDiplomename = $safeFilename1 . '-' . uniqid() . '.' . $diplomeFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $diplomeFile->move(
                            $this->getParameter('brochures_directory'),
                            $newDiplomename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $inscription->setDiplomeFilename($newDiplomename);
            }

            $inscriptionRepository->save($inscription, true);
            $this->addFlash('message', 'Modification avec scucès');
            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscription/edit.html.twig', [
                    'inscription' => $inscription,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}/inscription/', name: 'app_inscription_active', methods: ['POST'])]
    public function validateInscription(Request $request, Inscription $inscription, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        if ($this->isCsrfTokenValid('active' . $inscription->getId(), $request->request->get('_token'))) {

            //  $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $inscription->setUpdatedBy($user);
            $inscription->setEditable(1);
            $inscription->setUpdatedFromIp($this->GetIp());

            $entityManager->flush();
            $this->addFlash('success', 'Validation succès.');
        }

        return $this->redirectToRoute('app_inscription_index');
    }

    #[Route('/archive', name: 'app_inscription_archive', methods: ['GET', 'POST'])]
    public function archiveInscription(InscriptionRepository $inscriptionRepository): Response {
        $inscription = $inscriptionRepository->findBy(["editable" => 0]);
        return $this->render('inscription/archive.html.twig', [
                    'inscriptions' => $inscription,
        ]);
    }

    #[Route('/{id}', name: 'app_inscription_delete', methods: ['POST'])]
    public function delete(Request $request, Inscription $inscription, InscriptionRepository $inscriptionRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete' . $inscription->getId(), $request->request->get('_token'))) {
            $inscriptionRepository->remove($inscription, true);
        }

        return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
    }

}
