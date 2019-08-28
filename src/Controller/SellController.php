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
        return $this->render('sell/registration_user.html.twig.twig', [
            'controller_name' => 'SellController',
        ]);
    }
}
