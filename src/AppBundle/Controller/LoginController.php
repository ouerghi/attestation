<?php
//Login : ouerghi
//Mot de passe : MLR33TY8ZfUw  agent
//Login : ouerghi1
//Mot de passe : sQGWEn2NXM8w admin

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
  {
      // get the login error if there is one
      $error = $authenticationUtils->getLastAuthenticationError();

      // last username entered by the user
      $lastUsername = $authenticationUtils->getLastUsername();

      return $this->render('default/login.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
      ));


  }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        // logout path
    }
}