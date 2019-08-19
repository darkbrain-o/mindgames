<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandController extends AbstractController
{
    /**
     * @Route("/command", name="command")
     */
    public function index()
    {
        return $this->render('command/index.html.twig', [
            'controller_name' => 'CommandController',
        ]);
    }
}
