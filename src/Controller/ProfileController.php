<?php

namespace App\Controller;

use App\Form\EditprofileType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileController extends AbstractController
{
 

    
    
 #[Route('/editpass', name: 'user_modifier_editpass', methods: ['GET', 'POST'])]
    public function editPassAction(Request $request, UserPasswordHasherInterface $passwordEncoder, UserRepository $useRepository)
    {
        if($request->isMethod('POST')){
            $user = $this->getUser();
        if($request->request->get('pass') == $request->request->get('pass2'));
            $user->setPassword($passwordEncoder->hashPassword($user, $request->request->get('pass')));
            $useRepository->save($user, true);

            return $this->redirectToRoute('app_logout');
         
        } else {
               $this->addFlash(
                    'error',
                    'Les 2 mots de passe ne correspondent pas.'
                );  
        }
        return $this->render('user/editpass.html.twig');     

    }
    
    
    
 #[Route('/editprofile', name: 'user_modifier_profile', methods: ['GET', 'POST'])]
    public function editerProfilAction(Request $request, SluggerInterface $slugger, UserRepository $userRepository)
    {
        // Recupere l'utilisateur courant
        $user = $this->getUser();
     
        if (null === $user) {
            return $this->redirectToRoute('app_logout');
        }

        // Creation du formulaire d'edition
        $editUserForm = $this->createForm(EditprofileType::class, $user);

        // On indique au formulaire de prendre en charge le contenu de la requete
        // Il va mapper les different champs soumis avec le contenu de l entite $user
        $editUserForm->handleRequest($request);

        if ($request->isMethod('POST')) {
        if ($editUserForm->isSubmitted()) {
        ;
            
        
              /** @var UploadedFile $brochureFile */
            $brochureFile = $editUserForm->get('brochure')->getData();

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
                


      
                $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
//                $user->setUserConfirmationToken($token);
            $userRepository->save($user, true);

                // TO DO ENVOYER UN MAIL DE CONFIRMATION POUR ACTIVER LE COMPTE

                $this->addFlash(
                    'success',
                    'Vos modifications ont bien etes enregistrees.'
                );

                return $this->redirectToRoute('app_accueil');
            }
        }

        // Affichage
        return $this->render('user/editprofile.html.twig', [
            'form' => $editUserForm->createView(),
            'libAction' => 'Modifier'
        ]);
    }
    
}

