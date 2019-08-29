<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilFormType;
use App\Form\SignUpFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Flex\Response;

class UserController extends AbstractController
{
    /**
     * @Route("/monProfil", name="myProfil")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function showProfil(Request $request, ObjectManager $objectManager, UserPasswordEncoderInterface $encoder,SessionInterface $session , User $user = null)
    {
        if($user === null and $session === null){
            $user = new User();  // create user
            
       }
    //    elseif($user->getOwner() !==  $this->getUser()){
    //        throw $this->createAccessDeniedException();
    //    }
        $user = $this->getUser();

        $form = $this->createForm(ProfilFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
            // if($user->getPicture() !== null){
            //     //On gère le déplacement du fichier uploadé depuis la localisation temporaire
            //     //vers la localisation permanente (public/uploads)
            //     /** @var UploadedFile $imageFile */
            //     $imageFile = $user->getPicture();
            //     $folder = 'uploads'; $filename = uniqid();
            //     //MAUVAISE PRATIQUE, EN REALITE IL FAUT -->
            //     //Prendre l'image puis la regénérer grâce à, par exemple, la librairie GD.
            //     $imageFile->move($folder, $filename);
            //     $user->setPicture($folder . DIRECTORY_SEPARATOR . $filename);
            // }
            $objectManager->persist($user);
            $objectManager->flush();

            return $this->redirectToRoute('home');
        }
        
        return $this->render('form/profil_form.html.twig', [
            'profil_form' => $form->createView(),
            'user' => $user,
        ]);
    }
    /**
     * @Route("/inscription", name="signup")
     */
    public function signUp(Request $request, ObjectManager $objectManager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $signUpForm = $this->createForm(SignUpFormType::class, $user);

        $signUpForm->handleRequest($request);

        if($signUpForm->isSubmitted() && $signUpForm->isValid()){
            //Récupérer et hasher le mot de passe, puis le set
            $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            if ($user->getImageFile() !== null) {
                // On va gérer ici le déplacement du fichier uploadé la localisation temporaire
                // Vers la localisation permanente (public/uploads)
                /** @var UploadedFile $imageFile  */
                $imageFile = $user->getImageFile();
    
                $folder = 'uploads'; 
                
                $filename = uniqid();
                
    
                $imageFile->move($folder, $filename);
    
                $user->setImage($folder . DIRECTORY_SEPARATOR . $filename);
                
                }

            //On ajoute le rôle ROLE_USER à notre Utilisateur
            $user->setRole('ROLE_USER');

            //On ajoute l'utilisateur à la base
            $objectManager->persist($user);
            $objectManager->flush();

            //On redirige l'utilisateur vers le formulaire de connexion
            return $this->redirectToRoute('app_login');
        }

        return $this->render('base_user_form.html.twig', [
            'signup_form' => $signUpForm->createView(),
        ]);
    }
}
