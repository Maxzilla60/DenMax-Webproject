<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class LoginController extends Controller
{
    /**
    *  @Route("/login", name="loginpage")
    */
    public function loginAction(Request $request) {
        if ($request->getSession()->get('username') != null) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('AppBundle:Login:login.html.twig');
    }
    
    /**
    *  @Route("/login/go")
    */
    public function loginGoAction(Request $request) {        
        $username = $request->request->get('username');
        
        if ($username == null) {
            return $this->redirectToRoute('loginpage');
        }
        
        $stuff = json_decode(file_get_contents("http://192.168.33.11/users/username/".$username));
        
        if (count($stuff) < 1) {
            return $this->redirectToRoute('loginpage');
        }
        
        $session = $request->getSession();
        $session->set('username', $username);
        $session->set('role', $stuff[0]->role);
        $session->set('id', $stuff[0]->id);
        
        $stuff = json_decode(file_get_contents("http://192.168.33.11/companies/user/".$stuff[0]->id));
        
        if (count($stuff) < 1) {
            $session->set('company', null);
            $session->set('company_id', null);
        }
        else {
            $session->set('company', $stuff[0]->name);
            $session->set('company_id', $stuff[0]->id);
        }

        return $this->redirectToRoute('home');
    }
    
    /**
    *   @Route("/logout", name="logout")
    */
    public function logoutAction(Request $request) {
        $request->getSession()->clear();
        
        return $this->redirectToRoute('home');
    }
}
