<?php

namespace App\Controller;

use App\Entity\Command;
use App\Form\CommandEditFormType;
use App\Repository\UserRepository;
use App\Repository\CommandRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CommandController extends AbstractController
{
    /**
     * @Route("/command", name="commands")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editCommand(Request $request,
     ObjectManager $objectManager,
     Command $command = null,
     UserRepository $userRepository
     )
    {

        $titleName = 'Modifier';

        if($command === null) {
            $titleName = 'Ajouter';
            $command = new Command();
        } 

        $commandForm = $this->createForm(CommandEditFormType::class, $command);

        $commandForm->handleRequest($request);

        if($commandForm->isSubmitted() && $commandForm->isValid()) {


            $user = $userRepository->findOneBy(["pseudo"=>$command->getUserCommand()]);

            $command->setUser($user);

            $objectManager->persist($command);
            $objectManager->flush();

            //On va redirigé l'utilisateur vers le formulaire de connexion
            return $this->redirectToRoute('commands');
        }

        return $this->render('command/edit.html.twig', [
            'title_name' => $titleName,
            'command_form' => $commandForm->createView()
        ]);
    }

    //--------------Partie DELETE----------------

    /**
     * @Route("/command/delete/{id<\d+>}", name="delete_command")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteCommand(Command $command, ObjectManager $objectManager)
    {
        
        // on supprime le produit
        $objectManager->remove($command);
        $objectManager->flush();
        return $this->redirectToRoute('mycommands');
    }
}
