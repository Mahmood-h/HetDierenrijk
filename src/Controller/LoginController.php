<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
#[Route('/login', name: 'app_login')]

    public function index(AuthenticationUtils $authenticationUtils): Response
{

           $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();



            return $this->render('login/index.html.twig', [

                           'last_username' => $lastUsername,
                           'error'         => $error,
          ]);
      }
     #[Route("/redirect", name:"redirect")]
     public function redirectAction(Security $security){
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
         }
        if ($security->isGranted('ROLE_USER')){
            return $this->redirectToRoute('app_member');
         }

        return $this->redirectToRoute('app_home');


     }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): never
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
