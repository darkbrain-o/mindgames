<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/game/{id<\d+>}", name="game")
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
            'classGradien' => 'bgGradienRight',
            'okpascool' => 'ok c\'est pas cool',
        ]);
    }
}
