<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/{page<\d*>}", name="home")
     */
    public function index(GameRepository $gameRepository,        PaginatorInterface $paginatorInterface,
    $page = 0)
    {
        

        $gamesQuery = $gameRepository->createQueryBuilder('p')
            ->orderBy('p.creation_date', 'desc')
            ->getQuery();

            $games = $paginatorInterface->paginate($gamesQuery, (int)$page = 1, 6);
            $lastGames = $gameRepository->findBy([], ['creation_date' => 'DESC'], 6);



        return $this->render('home/home.html.twig', [
            'games' => $games,
            'last_games' => $lastGames,
            
        ]);
    }


}
