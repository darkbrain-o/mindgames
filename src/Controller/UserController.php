<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilFormType;
use App\Form\SignUpFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/mon_profil", name="myProfil")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function showProfil(Request $request, ObjectManager $objectManager, UserPasswordEncoderInterface $encoder, User $user = null)
    {   
        if($user === null){
           $user = new User();
            $user = $this->getUser(); 
        }

        $form = $this->createForm(ProfilFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()){// && $form->isValid()) {
            // if(!empty($user->getPassword())){//$user->getPassword() !== null && 
            //    $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
            // }
            
            if ($user->getPictureFile() !== null) {

                // on gère ici le déplacement du fichier uploadé depuis la localisation temporaire
                // vers la localisation permanente (public/uploads)

                /** @var UploadedFile $imageFile */

                $imageFile = $user->getPictureFile();

                $folder = 'uploads';
                $filename = uniqid();

                $imageFile->move($folder, $filename);

                $user->setPicture($folder . DIRECTORY_SEPARATOR . $filename);
            }

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

        if ($signUpForm->isSubmitted() && $signUpForm->isValid()) {
            //Récupérer et hasher le mot de passe, puis le set
            $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            if ($user->getPictureFile() !== null) {
                // On va gérer ici le déplacement du fichier uploadé la localisation temporaire
                // Vers la localisation permanente (public/uploads)
                /** @var UploadedFile $imageFile  */
                $imageFile = $user->getPictureFile();
    
                $folder = 'uploads'; 
                
                $filename = uniqid();
                
    
                $imageFile->move($folder, $filename);
    
                $user->setPicture($folder . DIRECTORY_SEPARATOR . $filename);
                
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

    //------------------------   PARTIE ADMINISTRATION   ---------------------------

    /**
     * @Route("/liste_utilisateurs", name="list_user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function index(UserRepository $userRepository)
    {
        $user = $userRepository->findAll();

        return $this->render('user/list_users.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/utilisateur/{id<\d+>}", name="details_user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function detailUser(UserRepository $userRepository, User $user)
    {
        $id = $user->getId();
        $userById = $userRepository->find($id);

        return $this->render('user/details.html.twig', [
            'user' => $userById,
        ]);
    }

    /**
     * @Route("/utilisateur/ajouter", name="add_user")
     * @Route("/utilisateur/editer/{id<\d+>}", name="edit_user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function EditUser(Request $request, ObjectManager $objectManager, User $user = null, UserPasswordEncoderInterface $encoder)
    {
        $titleName = 'Ajouter';
        
        if ($user === null) {
            $titleName = 'Ajouter';
            $user = new User();
        }

        $userForm = $this->createForm(SignUpFormType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            //Récupérer et hasher le mot de passe, puis le set
            $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            if ($user->getPictureFile() !== null) {
                // On va gérer ici le déplacement du fichier uploadé la localisation temporaire
                // Vers la localisation permanente (public/uploads)
                /** @var UploadedFile $imageFile  */
                $imageFile = $user->getPictureFile();
    
                $folder = 'uploads'; 
                
                $filename = uniqid();
                
    
                $imageFile->move($folder, $filename);
    
                $user->setPicture($folder . DIRECTORY_SEPARATOR . $filename);
                
                }

            //On ajoute le rôle ROLE_USER à notre Utilisateur
            $user->setRole('ROLE_USER');

            //On ajoute l'utilisateur à la base
            $objectManager->persist($user);
            $objectManager->flush();

            //On redirige l'utilisateur vers le formulaire de connexion
            return $this->redirectToRoute('list_user');
        }

        return $this->render('user/edit.html.twig', [
            'title_name' => $titleName,
            'user_form' => $userForm->createView(),
        ]);
    }

    /**
     * @Route("/utilisateur/supprimer/{id<\d+>}", name="delete_user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteGame(User $user, ObjectManager $objectManager)
    {
        // on supprime le produit
        $objectManager->remove($user);
        $objectManager->flush();
        return $this->redirectToRoute('list_user');
    }
}
