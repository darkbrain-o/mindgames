<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SellController extends AbstractController
{
    /**
     * @Route("/sell", name="sell")
     */
    public function index()
    {
        return $this->render('sell/index.html.twig', [
            'controller_name' => 'SellController',
        ]);
    }
}
