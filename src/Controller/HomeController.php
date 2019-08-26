<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/home_admin", name="home_admin")
     */
    public function indexAdmin()
    {
        return $this->render('home_admin/home_admin.html.twig');
    }
}
