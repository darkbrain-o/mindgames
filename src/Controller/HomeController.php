<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    /**
     * @Route("/{page<\d+>}", name="home")
     */
    public function index(GameRepository $gameRepository,        PaginatorInterface $paginatorInterface,
    $page = 1)
    {
        $gamesQuery = $gameRepository->createQueryBuilder('p')
            ->orderBy('p.creation_date', 'desc')
            ->getQuery();

        $games = $paginatorInterface->paginate($gamesQuery, (int)$page, 6);
        $lastGames = $gameRepository->findBy([], ['creation_date' => 'DESC'], 6);

        return $this->render('home/home.html.twig', [
            'games' => $games,
            'last_games' => $lastGames,
        ]);
    }

    /**
     * @Route("/admin", name="home_admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAdmin()
    {
        return $this->render('home_admin/home_admin.html.twig');
    }
}
