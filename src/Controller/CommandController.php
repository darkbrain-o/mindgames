<?php

namespace App\Controller;

use App\Entity\Command;
use App\Form\CommandEditFormType;
use App\Repository\CommandRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CommandController extends AbstractController
{
    /**
     * @Route("/command", name="commands")
     */
    public function index(CommandRepository $commandRepository)
    {
        $command = $commandRepository->findAll();

        return $this->render('command/command.html.twig', [
            'controller_name' => 'CommandController',
        ]);
    }

    //-------------------Détails command--------------------------------

    /**
     * @Route("/command/{id<\d+>}", name="details_command")
     */
    public function details(Command $command, CommandRepository $commandRepository)
    {
        $id = $command->getId();
        $commandById = $commandRepository->find($id);

        return $this->render('command/details.html.twig', [
            'command' => $commandById
        ]);
    }

      //------------------Partie EDIT------------------------

      //-------------------------------------------------------
      //--------------/!\ probleme de fk_user dans le edit/!\--------------
      //------------------------------------------------------
    /**
     * @Route("/command/add", name="add_command")
     * @Route("/command/edit/{id<\d+>}", name="edit_command")
     */
    public function editCommand(Request $request,
     ObjectManager $objectManager,
     Command $command = null
     )
    {
        $titleName = 'Modifier';

        if($command === null) {
            $titleName = 'Ajouter';
            $command = new Command();
        } 
        // elseif($command->getOwner() !== $this->getUser()) {
        //     throw $this->createAccessDeniedException();
        // }


        $commandForm = $this->createForm(CommandEditFormType::class, $command);

        $commandForm->handleRequest($request);

        if($commandForm->isSubmitted() && $commandForm->isValid()) {


            $command->setCreationDate(new \DateTime());
            if($command->getImageFile() !== null) {

                // on gère ici le déplacement du fichier uploadé depuis la localisation temporaire
                // vers la localisation permanente (public/uploads)

                /** @var UploadedFile $imageFile */

                $imageFile = $command->getImageFile();

                $folder = 'uploads';
                 $filename = uniqid();

                $imageFile->move($folder, $filename);

                $command->setImage($folder . DIRECTORY_SEPARATOR . $filename);


            }

            $command->setOwner($this->getUser());
            //On ajoute l'utilisateur a la base

            $objectManager->persist($command);

            $objectManager->flush();

            //On va redirigé l'utilisateur vers le formulaire de connexion
            return $this->redirectToRoute('home');
        }

        return $this->render('command/edit.html.twig', [
            'title_name' => $titleName,
            'command_form' => $commandForm->createView()
        ]);
    }

    //--------------Partie DELETE----------------

    /**
     * @Route("/command/delete/{id<\d+>}", name="delete_command")
     */
    public function deleteCommand(Command $command, ObjectManager $objectManager)
    {
        
        // on supprime le produit
        $objectManager->remove($command);
        $objectManager->flush();
        return $this->redirectToRoute('mycommands');
    }
}
