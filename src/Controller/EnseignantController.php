<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\EnseignantRepository;
use App\Traits\ClientIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Twig\DateFormatExtension;

#[Route('/enseignant')]
class EnseignantController extends AbstractController {

    use ClientIp;

    #[Route('/', name: 'app_enseignant_index', methods: ['GET'])]
    public function index(EnseignantRepository $enseignantRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $liste = ["deletedAt" => Null];
        $limit = 1000;
        return $this->render('enseignant/index.html.twig', [
                    'enseignants' => $enseignantRepository->findBy($liste, ["nom" => "ASC"]),
        ]);
    }

    #[Route('/new', name: 'app_enseignant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EnseignantRepository $enseignantRepository, SluggerInterface $slugger): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $enseignant = new Enseignant();
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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
                $enseignant->setCreatedFromIp($this->GetIp()); // remplacement de la function par le trait
                //  ->setCreatedBy($user);
                $enseignant->setCreatedAt(new \DateTimeImmutable("now"));
                $enseignant->setBrochureFilename($newFilename);
            };

            $enseignantRepository->save($enseignant, true);

            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'app_enseignant_new' : 'app_enseignant_index';
            if ($nextAction) {
                $this->addFlash('enseignant', 'Action effectuée avec succès.');
            }

            return $this->redirectToRoute($nextAction);
        }

        $response = new Response(null, $form->isSubmitted() ? 422 : 200);

        return $this->render('enseignant/new.html.twig', [
                    'enseignant' => $enseignant,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enseignant_show', methods: ['GET'])]
    public function show(Enseignant $enseignant): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('enseignant/show.html.twig', [
                    'enseignant' => $enseignant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enseignant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enseignant $enseignant, EnseignantRepository $enseignantRepository, SluggerInterface $slugger): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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
                $enseignant->setUpdatedFromIp($this->GetIp()); // remplacement de la function par le trait
                //  ->setCreatedBy($user);
                $enseignant->setUpdatedAt(new \DateTimeImmutable("now"));
                $enseignant->setBrochureFilename($newFilename);
            };
            $enseignantRepository->save($enseignant, true);

            return $this->redirectToRoute('app_enseignant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enseignant/edit.html.twig', [
                    'enseignant' => $enseignant,
                    'form' => $form,
        ]);
    }

    #[Route('/delete', name: 'app_enseignant_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, EnseignantRepository $enseignantRepository, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $id = $request->request->get('delete_value');
        $LigneUpdate = $enseignantRepository->find($id);
        $LigneUpdate->setDeletedFromIp($this->GetIp());
        $user = $this->getUser();
        //  $LigneUpdate->setDeletedBy($user);
        $LigneUpdate->setDeletedAt(new \DateTimeImmutable("now"));
        $entityManager->flush();
        return $this->json(["data" => "Suppression effectuée avec succès"], 200, ["Content-type" => "application-json"]);
        // return $this->redirectToRoute('app_enseignant_index', [], Response::HTTP_SEE_OTHER);
    }

}
