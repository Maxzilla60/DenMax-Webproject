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
        // Check if someone is already logged in:
        if ($request->getSession()->get('username') != null) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('AppBundle:Login:login.html.twig');
    }
    
    /**
    *  @Route("/login/go")
    */
    public function loginGoAction(Request $request) {
        // Get username from POST request variables
        $username = $request->request->get('username');
        // Check if POST variable is set:
        if ($username == null) {
            return $this->redirectToRoute('loginpage');
        }
        
        // Fetch user from API
        $fetchedUsers = json_decode(file_get_contents("http://192.168.33.11/users/username/".$username));
        // Check if user exists:
        if (count($fetchedUsers) < 1) {
            return $this->redirectToRoute('loginpage');
        }
        
        // Get and set new session cookies:
        $session = $request->getSession();
        $session->set('username', $username);
        $session->set('role', $fetchedUsers[0]->role);
        $session->set('id', $fetchedUsers[0]->id);
        
        // Fetch user's company from API
        $fetchedCompanies = json_decode(file_get_contents("http://192.168.33.11/companies/user/".$fetchedUsers[0]->id));
        // Check if user has a company and set session cookies:
        if (count($fetchedCompanies) < 1) {
            $session->set('company', null);
            $session->set('company_id', null);
        }
        else {
            $session->set('company', $fetchedCompanies[0]->name);
            $session->set('company_id', $fetchedCompanies[0]->id);
        }

        return $this->redirectToRoute('home');
    }
    
    /**
    *   @Route("/logout", name="logout")
    */
    public function logoutAction(Request $request) {
        // Clear session cookies and redirect:
        $request->getSession()->clear();
        return $this->redirectToRoute('home');
    }
}
