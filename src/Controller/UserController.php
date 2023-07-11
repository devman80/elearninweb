<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditpassType;
use App\Form\EditprofileType;
use App\Form\EdituserType;
use App\Form\UserType;
use App\Repository\DispenserRepository;
use App\Repository\InscriptionRepository;
use App\Repository\MatiereRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/user')]
class UserController extends AbstractController {

    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        $user = $userRepository->findBy(["editable" => 1]);
        return $this->render('user/index.html.twig', [
                    'user' => $user,
        ]);
    }

    #[Route('/archive', name: 'registration_archive', methods: ['GET', 'POST'])]
    public function archiveUser(UserRepository $userRepository): Response {
        $user = $userRepository->findBy(["editable" => 0]);
        return $this->render('user/archive.html.twig', [
                    'user' => $user,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
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

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setBrochureFilename($newFilename);
            }
            $user->setCreatedAt(new DateTime("now"));
            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                    )
            );
            $userRepository->save($user, true);
            $this->addFlash('message', 'Enregistrerment avec succès.');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
                    'user' => $user,
                    'form' => $form,
        ]);
    }

    #[Route('/editprofile', name: 'user_modifier_profile', methods: ['GET', 'POST'])]
    public function modifierAction(Request $request, SluggerInterface $slugger, UserRepository $userRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(EditprofileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
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

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setBrochureFilename($newFilename);
            }

            $this->addFlash('message', 'Profil mis à jour avec succès');
            $userRepository->save($user, true);
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/editprofile.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('/profile', name: 'app_user_profile', methods: ['GET', 'POST'])]
    public function profileAction(InscriptionRepository $inscriptionRepos, MatiereRepository $matiereRepos) {
        // Recupere l'utilisateur courant
        $user = $this->getUser();
        $idUser = $user->getId();
        $inscrit = $inscriptionRepos->findBy(array('createdBy' => $idUser), array('id' => 'desc'), 1, 0);
        $phone = '';
        $section = '';
        $nationalite = '';
        $habitation = '';

        foreach ($inscrit as $key => $value) {
            $phone = $value->getTelephone();
            $section = $value->getSection();
            $nationalite = $value->getPaysnaiss();
            $habitation = $value->getLieuresidence();
        }

        $listeMatieres = $matiereRepos->findBy(['section' => $section]);
        $listecours = $matiereRepos->matieresGroupByCours();
      
        if (null === $user) {
            return $this->redirectToRoute('app_home128');
        }

        return $this->render('user/profile.html.twig', [
                    'phone' => $phone,
                    'section' => $section,
                    'nationalite' => $nationalite,
                    'habitation' => $habitation,
                    'matieres' => $listeMatieres,
                    'cours' => $listecours,
        ]);
    }

    #[Route('/membre/{id}', name: 'app_user_listelesson', methods: ['GET', 'POST'])]
    public function listeLesson(Request $request, DispenserRepository $dispenserRepository, MatiereRepository $matiereRepository) {
        //Recuperation id matiere
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $idmatiere = $request->query->get('id');
        //Recuperation de la liste des dispenser par quartier
        $listeDispenser = $dispenserRepository->findBy(['matiere' => $idmatiere, 'deletedAt' => NULL]);
        $lignematiere = $matiereRepository->find($idmatiere);
        $nommatiere = $lignematiere->getLibelle();

        return $this->render('user/listelesson.html.twig', [
                    'dispensers' => $listeDispenser,
                    'nommatiere' => $nommatiere,
        ]);
    }

    #[Route('/editpass', name: 'user_modifier_editpass', methods: ['GET', 'POST'])]
    public function modifpass(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        if (null === $user) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(EditpassType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                    )
            );
            $this->addFlash('message', 'Profil mis à jour avec succès');
            $userRepository->save($user, true);

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/editpass.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher): Response {
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        $form = $this->createForm(EdituserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user, true);
            $this->addFlash('message', 'Modification avec succès.');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_registration_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {

            $user->setDeletedAt(new DateTimeImmutable('now'));
            $user->setEditable(0);

            $this->addFlash('succes', 'Fermeture du compte avec succès.');
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/user/', name: 'app_registration_active', methods: ['POST'])]
    public function validateUser(Request $request, User $user, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès réfusé, vous n\'avez pas les droits d\'accès ici!');
        }
        if ($this->isCsrfTokenValid('active' . $user->getId(), $request->request->get('_token'))) {

            //  $entityManager = $this->getDoctrine()->getManager();

            $user->setDeletedAt(NULL);
            $user->setEditable(1);

            $this->addFlash('succes', 'Activation du compte avec succès.');
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index');
    }

}
