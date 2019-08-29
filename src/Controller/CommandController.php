<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandController extends AbstractController
{


    /**
    * @Route("/command", name="command")
    */
    public function confirmCommand(SessionInterface $session, Request $request )
    {
                // Delete row bucket
        
            $command = $session->get('bucket');

        
            return $this->render('command/command.html.twig', [
                'command' => $command,
            ]);    
    }

    /**
     * @Route("/detail", name="detail_command")
     */
    public function detailCmd()
    {
        return $this->render('command/detail_command.html.twig', [
            'controller_name' => 'CommandController',
        ]);
    }
    
    /**
     * @Route("/modifier", name="edit_command")
     */
    public function editCmd()
    {
        return $this->render('command/edit_command.html.twig', [
            'controller_name' => 'CommandController',
        ]);
    }
}
