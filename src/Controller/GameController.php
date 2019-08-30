<?php

namespace App\Controller;

use App\Entity\Game;

use App\Form\GameAddFormType;
use App\Form\GameEditAdminType;
use App\Repository\CommandRepository;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class GameController extends AbstractController
{
    /**
     * @Route("/liste_jeux", name="liste_jeux")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function index(GameRepository $gameRepository)
    {
        $games = $gameRepository->findAll();

        return $this->render('game/list_admin_games.html.twig', [
            'game' => $games,
        ]);
    }

    //-------------------Détails game--------------------------------

    /**
     * @Route("/game/{id<\d+>}", name="details_game")
     */
    public function detailGame(GameRepository $gameRepository, Game $game)
    {
        $id = $game->getId();
        $creationDate = $game->getCreationDate();
        $gameById = $gameRepository->find($id);

        $directionLinearG = 2;
        // Sens linear gradien template for class | 0 = null |  1= turn | 2 = to right
        // injecter 'directionLinearG' => $directionLinearG,

        return $this->render('game/game.html.twig', [
            'game' => $gameById,
            'creation_date' => $creationDate,
            'directionLinearG' => $directionLinearG,
            'classGradien' => 'bgGradienRight'
        ]);
    }

    /**
     * @Route("/game_admin/{id<\d+>}", name="details_game_admin")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function detailGameAdmin(GameRepository $gameRepository, Game $game)
    {
        $id = $game->getId();
        $creationDate = $game->getCreationDate();
        $gameById = $gameRepository->find($id);

        $directionLinearG = 2;
        // Sens linear gradien template for class | 0 = null |  1= turn | 2 = to right
        // injecter 'directionLinearG' => $directionLinearG,

        return $this->render('game/details_admin.html.twig', [
            'game' => $gameById,
            'creation_date' => $creationDate,
            'directionLinearG' => $directionLinearG,
            'classGradien' => 'bgGradienRight'
        ]);
    }

    //------------------Partie EDIT------------------------

    /**
     * @Route("/jeux/ajouter", name="add_game")
     */
    public function addGame(Request $request, GameRepository $gameRepository, ObjectManager $objectManager, Game $game = null)
    {
        
        $titleName = 'Ajouter';
        $game = new Game();
        $game->setStatus(0);
        
        $gameForm = $this->createForm(GameAddFormType::class, $game);

        $gameForm->handleRequest($request);
        
        if ($gameForm->isSubmitted()){// && $gameForm->isValid()) {
            $game->setCreationDate(new \DateTime());
            
            if ($game->getPictureFile() !== null) {
               
                // on gère ici le déplacement du fichier uploadé depuis la localisation temporaire
                // vers la localisation permanente (public/uploads)

                /** @var UploadedFile $imageFile */

                $imageFile = $game->getPictureFile();

                $folder = 'uploads';
                $filename = uniqid();
                
                $imageFile->move($folder, $filename);

                $game->setPicture($folder . DIRECTORY_SEPARATOR . $filename);
            }

            $objectManager->persist($game);
            $objectManager->flush();
            //On va redirigé l'utilisateur vers le formulaire de connexion
            return $this->redirectToRoute('home');
        }
        return $this->render('game/add_game.html.twig', [
            'title_name' => $titleName,
            'game_form' => $gameForm->createView(),
        ]);
    }


    /**
     * @Route("/game/add", name="adm_add_game")
     * @Route("/game/edit/{id<\d+>}", name="adm_edit_game")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminEditGame(Request $request, GameRepository $gameRepository, ObjectManager $objectManager, Game $game = null)
    {
        $titleName = 'Modifier';
        $gamepict = null;

        if ($game === null) {
            $titleName = 'Ajouter';
            $game = new Game();
            $game->setStatus(0);
        }else{
            $gamepict = $game->getPicture();
        }

        $gameForm = $this->createForm(GameEditAdminType::class, $game);

        $gameForm->handleRequest($request);

        if ($gameForm->isSubmitted()){// && $gameForm->isValid()) {
            $game->setCreationDate(new \DateTime());
            if ($game->getPictureFile() !== null) {

                // on gère ici le déplacement du fichier uploadé depuis la localisation temporaire
                // vers la localisation permanente (public/uploads)

                /** @var UploadedFile $imageFile */

                $imageFile = $game->getPictureFile();

                $folder = 'uploads';
                $filename = uniqid();

                $imageFile->move($folder, $filename);

                $game->setPicture($folder . DIRECTORY_SEPARATOR . $filename);
            }

            $objectManager->persist($game);
            $objectManager->flush();

            //On va redirigé l'utilisateur vers le formulaire de connexion
            return $this->redirectToRoute('liste_jeux');
        }

        return $this->render('game/edit_game_admin.html.twig', [
            'title_name' => $titleName,
            'game_form' => $gameForm->createView(),
            'classGradien' => 'bgGradienRight',
            'img_game' => $gamepict,
            
        ]);
    }



    //--------------Partie DELETE----------------

    /**
     * @Route("/game/delete/{id<\d+>}", name="delete_game")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteGame(Game $game, ObjectManager $objectManager)
    {

        // on supprime le produit
        $objectManager->remove($game);
        $objectManager->flush();
        return $this->redirectToRoute('liste_jeux');
    }
}
