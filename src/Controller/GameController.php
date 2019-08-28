<?php

namespace App\Controller;

use App\Entity\Game;

use App\Form\GameEditFormType;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class GameController extends AbstractController
{
    /**
     * @Route("/liste_jeux", name="liste_jeux")
     */
    public function index(GameRepository $gameRepository)
    {

        $games = $gameRepository->findAll();

        return $this->render('game/list_admin_games.html.twig', [
            'game' => $games,
        ]);
    }



//----------------------------------------------------------------------

// On ajoute ici les ajout, modif et supprission d'article "game"

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

        return $this->render('game/details.html.twig', [
            'game' => $gameById,
            'creation_date' => $creationDate,
            'directionLinearG' => $directionLinearG,
            'classGradien' => 'bgGradienRight',
            'okpascool' => 'ok c\'est pas cool',
        ]);
    }

    /**
     * @Route("/game_admin/{id<\d+>}", name="details_game_admin")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
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
            'classGradien' => 'bgGradienRight',
            'okpascool' => 'ok c\'est pas cool',
        ]);
    }

    //------------------Partie EDIT------------------------

    /**
     * @Route("/game/add", name="add_game")
     * @Route("/game/edit/{id<\d+>}", name="edit_game")
     */
    public function editGame(Request $request,
                             ObjectManager $objectManager,
                             Game $game = null
    )
    {
        $titleName = 'Modifier';

        if($game === null) {
            $titleName = 'Ajouter';
            $game = new Game();
        }
        // elseif($game->getOwner() !== $this->getUser()) {
        //     throw $this->createAccessDeniedException();
        // }


        $gameForm = $this->createForm(GameEditFormType::class, $game);

        $gameForm->handleRequest($request);

        if($gameForm->isSubmitted() && $gameForm->isValid()) {


            $game->setCreationDate(new \DateTime());
            // if($game->getImageFile() !== null) {

            //     // on gère ici le déplacement du fichier uploadé depuis la localisation temporaire
            //     // vers la localisation permanente (public/uploads)

            //     /** @var UploadedFile $imageFile */

            //     $imageFile = $game->getImageFile();

            //     $folder = 'uploads';
            //      $filename = uniqid();

            //     $imageFile->move($folder, $filename);

            //     $game->setImage($folder . DIRECTORY_SEPARATOR . $filename);


            // }

            // $game->setOwner($this->getUser());
            //On ajoute l'utilisateur a la base

            $objectManager->persist($game);

            $objectManager->flush();

            //On va redirigé l'utilisateur vers le formulaire de connexion
            return $this->redirectToRoute('liste_jeux');
        }

        return $this->render('game/edit.html.twig', [
            'title_name' => $titleName,
            'game_form' => $gameForm->createView()
        ]);
    }



    //--------------Partie DELETE----------------

    /**
     * @Route("/game/delete/{id<\d+>}", name="delete_game")
     */
    public function deleteGame(Game $game, ObjectManager $objectManager)
    {

        // on supprime le produit
        $objectManager->remove($game);
        $objectManager->flush();
        return $this->redirectToRoute('liste_jeux');
    }
}
