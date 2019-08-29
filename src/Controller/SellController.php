<?php

namespace App\Controller;
/*  */

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\CommandRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SellController extends AbstractController
{

    /**
    * @Route("/monPanier", name="mon_panier")
    */
    public function Bucket(SessionInterface $session, Request $request, GameRepository $gameRepository )
    {

        $bucket = $session->get('bucket', []);

        if ($request->request->get('selectNbGames') and $request->request->get('idGame') ) {
            
            $nbGames = $request->request->get('selectNbGames');
            $idGame = $request->request->get('idGame');

            // Prix total par jeu
            $game = $gameRepository->find($idGame);
            $TotalPriceByGame = $nbGames * $game->getPrice();
             
            $bucket[$idGame]= [
                'idGame' => $idGame,
                'nbGame' => $nbGames,
                'totalPriceByGame' => $TotalPriceByGame,
            ];
    
            $session->set('bucket', $bucket);
        }

        // Delete row bucket
        if ($request->request->get('idGameDelete') ) {
            
            
            $idGame = $request->request->get('idGameDelete');

            
           unset($bucket[$idGame]);
    
            $session->set('bucket', $bucket);
        }


        

        // SELECT * FROM game WHERE id = 1
        $games = $gameRepository->createQueryBuilder('g')
            ->where('g.id IN (:ids)')
            ->setParameter('ids', array_keys($bucket))
            ->getQuery()
            ->getResult();

        foreach($games as $game) {
            $bucket[$game->getId()]['game'] = $game;
        }
        
        // Delete row bucket
        if ($request->request->get('deleteBucket') ) {
                
            $bucket = $request->request->get('deleteBucket');

            $bucket = [];
           
            $session->set('bucket', $bucket);
        }
        
    


        return $this->render('command/mon_panier.html.twig', [
            'bucket' => $bucket,
            
        ]);

    }

    /*
     * @Route("/buy", name="buy")
     */
    public function buyGame(CommandRepository $commandRepository,GameRepository $gameRepository, Game $game)
    {
        // Recuperation de l'id du jeu 
        $id = $game->getId();
        $creationDate = $game->getCreationDate();
        $gameById = $gameRepository->find($id);

        // Ajout du jeu au panier


        $directionLinearG = 2; 
        // Sens linear gradien template for class | 0 = null |  1= turn | 2 = to right
        // injecter 'directionLinearG' => $directionLinearG,

        return $this->render('game/game.html.twig', [
            'game' => $gameById,
            'creation_date' => $creationDate,
            'directionLinearG' => $directionLinearG,
            'classGradien' => 'bgGradienRight',
            
        ]);
    }
}
