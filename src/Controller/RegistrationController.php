<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Entity\Inscription;
use App\Entity\Section;
use App\Entity\Stagiaire;
use App\Entity\User;
use App\Entity\Paiement;
use App\Form\RegistrationFormType;
use App\Repository\InscriptionRepository;
use App\Repository\PaiementRepository;
use App\Repository\SectionRepository;
use App\Repository\UserRepository;
use App\Repository\VersementRepository;
use App\Security\EmailVerifier;
use App\Security\UsersAuthenticator;
use App\Service\FileUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\OrderBy;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController {

    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier) {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request,
            UserPasswordHasherInterface $userPasswordHasher,
            UserAuthenticatorInterface $userAuthenticator,
            UsersAuthenticator $authenticator,
            EntityManagerInterface $entityManager,
            FileUploader $fileUploader, InscriptionRepository $inscriptionRepository, SectionRepository $setionRepos): Response {
        //   $user = new User();
        $liste = ['message' => 'create form'];
        $form = $this->createForm(RegistrationFormType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $brochureFile = $data['brochureFilename'];
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
            }
            $cnirecto = $data['cniFilenamerecto'];
            if ($cnirecto) {
                $cnirectoFileName = $fileUploader->upload($cnirecto);
            } else {
                $cnirectoFileName = null;
            }
            $cniverso = $data['cniFilename'];
            if ($cniverso) {
                $cniversoFileName = $fileUploader->upload($cniverso);
            } else {
                $cniversoFileName = null;
            }

            $extrait = $data['extraitFilename'];
            if ($extrait) {
                $extraitFileName = $fileUploader->upload($extrait);
            } else {
                $extraitFileName = null;
            }

            $certificat = $data['certificatFilename'];
            if ($certificat) {
                $certificatFileName = $fileUploader->upload($certificat);
            } else {
                $certificatFileName = null;
            }
            $diplome = $data['diplomeFilename'];
            if ($diplome) {
                $diplomeFileName = $fileUploader->upload($diplome);
            } else {
                $diplomeFileName = null;
            }
            //enregistrement de user
            $user = new User();
            $user->setRoles(['ROLE_USER']);
            $user->setIsVerified(false);
            $user->setNom($data['nom']);
            $user->setEditable(1);
            $user->setSection($entityManager->find(Section::class, $data['section']->getId()));
            $user->setIsVerified(true);
            $user->setPrenom($data['prenom']);
            $user->setContact($data['contact']);
            $user->setEmail($data['email']);
            $user->setRoles(['ROLE_ETUDIANT']);
            $user->setCreatedAt(new DateTimeImmutable('now'));
            $user->setUpdatedAt(new DateTimeImmutable('now'));
            // encode the plain password
            $user->setPassword(
                    $userPasswordHasher->hashpassword(
                            $user,
                            $data['password']
                    )
            );

            if ($brochureFileName) {
                $user->setBrochureFilename($brochureFileName);
            }

            $entityManager->persist($user);

            //  Enregistrement stagiaire
            $stagiaire = new Stagiaire();
            $stagiaire->setNom($data['nom']);
            $stagiaire->setPrenom($data['prenom']);
            $stagiaire->setSexe($data['sexe']);
            //$stagiaire->setSection($entityManager->find(Section::class, $data['section']->getId()));
            if ($brochureFileName) {
                $stagiaire->setBrochureFilename($brochureFileName);
            }
            $stagiaire->setCreatedAt(new DateTimeImmutable('now'));
            $stagiaire->setUpdatedAt(new DateTimeImmutable('now'));
            $stagiaire->setCreatedBy($user);

            $entityManager->persist($stagiaire);

            //Enregistrement inscription
            // recuperation du montant de la section
            
            $montScolarite = $setionRepos->find($data['section']->getId());
             $resultScolarite = $montScolarite->getScolarite();
           
            
            $inscription = new Inscription();
            $inscription->setEmail($data['email']);
            $inscription->setNom($data['nom']);
            $inscription->setDiplomeFilename($diplomeFileName);
            $inscription->setPrenom($data['prenom']);
            $inscription->setSexe($data['sexe']);
            $inscription->setContact($data['contact']);
            $inscription->setTelephone($data['telephone']);

            $lesinscriptions = $inscriptionRepository->findBy(array(), array('id' => 'desc'), 1, 0);
            $id = 0;
            foreach ($lesinscriptions as $value) {
                $id = $value->getId();
            }
            $val = $id + 1;
            $idEnfant = substr($val, 0, 4);

            $naissance = (new DateTimeImmutable('now'));
            $child = $inscription->getNom();
            $conversion = $naissance->format('Y-m-d');
            $an = explode('-', $conversion);
            $nominscription = substr($child, 0, 2);
            $code = $an[0] . $nominscription . $idEnfant;
            $inscription->setCode($code);

            $inscription->setSection($entityManager->find(Section::class, $data['section']->getId()));
            $inscription->setRestepaye($resultScolarite);
            $inscription->setMontantInscription($resultScolarite);
            $inscription->setMontantpayer(0);
            $inscription->setCniFilenamerecto($cnirectoFileName);
            $inscription->setCniFilename($cniversoFileName);
            $inscription->setBrochureFilename($brochureFileName);
            $inscription->setCertificatFilename($certificatFileName);
            $inscription->setNumpiece($data['numpiece']);
            $inscription->setCmu($data['cmu']);
            $inscription->setPaysnaiss($data['paysnaiss']);
            $inscription->setPaysvit($data['paysvit']);
            $inscription->setCommune($entityManager->find(Commune::class, $data['commune']->getId()));
            $inscription->setExtraitFilename($extraitFileName);
           // $inscription->setHandicap($data['handicap']);
            $inscription->setTypehandicap($data['typehandicap']);
            $inscription->setStatutmatri($data['statutmatri']);
            $inscription->setTypepiece($data['typepiece']);
            $inscription->setDatenaissance($data['datenaissance']);

            // Verification de l'âge, l'auditeur doit avoir au moins 15 ans
            $datenaissance = $inscription->getDatenaissance();
            $formatyear = $datenaissance->format('Y');
            $aujourdhui = new DateTime("now");
            $formatojodui = $aujourdhui->format('Y');
            $age1 = ($formatojodui - $formatyear);
            if ($age1 < 15) {
                $this->addFlash('echec', 'Veuillez verifier la date de naissance.');
                return $this->redirect('register');
            }

            $inscription->setLieuresidence($data['lieuresidence']);
            $inscription->setCreatedAt(new DateTimeImmutable('now'));
            $inscription->setUpdatedAt(new DateTimeImmutable('now'));
            $inscription->setCreatedBy($user);
            $entityManager->persist($inscription);

            $entityManager->flush();

            // generate a signed url and email it to the user
//            $this->emailverifier->sendemailconfirmation('app_verify_email', $user,
//                (new templatedemail())
//                    ->from(new address('genialtech6@gmail.com', 'elearning group'))
//                    ->to($user->getemail())
//                    ->subject('please confirm your email')
//                    ->htmltemplate('registration/confirmation_email.html.twig')
//            );
//            // do anything else you need here, like send an email
//
//            return $userAuthenticator->authenticateuser(
//                $user,
//                $authenticator,
//                $request
//            );
            return $this->render('security/login.html.twig');
        }

        return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_home128');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre email a été vérifié.');

        return $this->redirectToRoute('app_register');
    }
     #[Route('/paiementpro', name: 'app_paiementpro')]
        public function paiementpro(Request $request,InscriptionRepository $inscriptionRepository,VersementRepository $versementRepository)
     {
        $data = $this->getUser();
        $listedata = $inscriptionRepository->findBy(["createdBy"=>$data->getId()],["id" =>"DESC"],"1","0");
         $nom       = "";
         $prenom    = "";
         $montant   = 0;
         $id        = "";
         $section   = "";
         $code      = 0;
         $montants  = 0;
        foreach ($listedata as $ldata){
            $nom       = $ldata->getNom();
            $prenom    = $ldata->getPrenom();
            $montant   = $ldata->getRestepaye();
            $id        = $ldata->getId();
            $code      = $ldata->getCodeversement();
            $section   = $ldata->getSection();
        }
        $email     = $data->getEmail();
        if($code == null || $code == 0){
            $code = 1;
        }else{
            $code = $code + 1;
        }
        $listeversement = $versementRepository->findBy(["code"=>$code,"section"=>$section]);
        foreach ($listeversement as $versement){
            $montants = $versement->getMontantversement();
        }

        $reste = $montant - $montants;
      //  dd([$nom,$prenom,$montant,$email,$id,$code]);

         return $this->render("registration/paiementpro.html.twig",
              [
               'nom'=>$nom,
               'prenom'=>$prenom,
               'mont'=>$montant,
               'email'=>$email,
               'id'=>$id,
               'montants'=>$montants,
               'reste' => $reste,
               'codepaie'=>$code,
              ]);
     }
    #[Route('/paiementprosend', name: 'app_paiementprosend',methods: 'POST')]
    public function paiementprosend(Request $request,InscriptionRepository $inscriptionRepository,UserRepository $userRepository,EntityManagerInterface $entityManager,PaiementRepository $paiementRepository)
    {
        $nom      = $request->request->get('nom');
        $prenom   = $request->request->get('prenom');
        $montant  = $request->request->get('montantapaye');
        $email    = $request->request->get('email');
        $telphone = $request->request->get('numero');
        $code     = $request->request->get('code');
        $id       = $request->request->get('id');
        $reste    = $request->request->get('resteapaye');
        $codepaie = $request->request->get('codepaie');

        $data = array(
            'merchantId' => "PP-F2322",
            'amount' => $montant,
            'description' => "Api PHP",
            'channel' => $code,
            'countryCurrencyCode' => "952",
            'referenceNumber' => "REF-" . time(),
            'customerEmail' => $email,
            'customerFirstName' => $nom,
            'customerLastname' => $prenom,
            'customerPhoneNumber' => $telphone,
            'notificationURL' => "http://www.cafop-lited.com/paiementproresult",
            'returnURL' => "http://www.cafop-lited.com/paiementpro",
            'returnContext' => '{"id":"'. $id.'","data":true}',
        );

        $data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paiementpro.net/webservice/onlinepayment/init/curl-init.php");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);

        curl_close($ch);

        $restResponse = json_decode($response);
        //Modification du champ isVerified

        $success = $restResponse->success;
        $url     = $restResponse->url;

        $reponses = "";
        if($success == 1){
            try {

                $auditeur = $inscriptionRepository->find($id);
                $section = $auditeur->getSection();
                //Modification du reste de la scolarite et du code de versement
                $auditeur->setRestepaye($reste);
                $auditeur->setCodeversement($codepaie);
                //Paiement scolarite
                $paiement = new paiement();
                $paiement->setSection($section);
                $paiement->setModepaiement($code);
                $paiement->setRestepaie($reste);
                $paiement->setInscription($auditeur);
                $paiement->setDatepaiement(new \DateTimeImmutable("now"));
                $paiement->setMontantpaiement($montant);
                $paiement->setCreatedAt(new \DateTimeImmutable("now"));
                $paiement->setCreatedBy($this->getUser());
                $entityManager->persist($paiement);
                $entityManager->flush();

                //Redirection pour effectuer le paiement
                return $this->redirect($url,302);
               // return $this->render('registration/succes.html.twig');

            } catch(Exception $e) {
                $reponses = $e->getMessage();
            }

            return $this->render('registration/paiementpro.html.twig');

        }else{
            return $this->redirectToRoute("app_user_profile");
        }


    }
    #[Route('/paiementproresult', name: 'app_paiementproresult',methods: ['POST','GET'])]
    public function paiementproresult(Request $request){
       $response = $request->toArray();

       $montant   = $response->amount;
       $number    = $response->referenceNumber;
       $dateheure = $response->transactiondt;
       $code      = $response->responsecode;
       $context   = $response->returnContext;
       $id        = $response->customerId;
       $madate = \DateTime::createFromFormat("Y-m-d H:i:s",$dateheure);
    }
}
