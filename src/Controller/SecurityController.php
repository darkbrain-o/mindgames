<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignInFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        if ($this->getUser()) {
           $this->redirectToRoute('myProfil');
        }
            
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        // $lastUsername = $authenticationUtils->getLastUsername();

        $loginForm = $this->createForm(SignInFormType::class);

        $loginForm->handleRequest($request);

        return $this->render('security/login.html.twig', ['login_form' => $loginForm->createView(), 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
