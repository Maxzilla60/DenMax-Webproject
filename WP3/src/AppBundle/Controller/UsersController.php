<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
    *  @Route("/technicians", name="technicians")
    */
    public function techniciansAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 2) {
            return $this->redirectToRoute('loginpage');
        }
        
        $stuff = json_decode(file_get_contents("http://192.168.33.11/users/role/0"));
        
        return $this->render('AppBundle:Users:technicians.html.twig', array("users" => $stuff));
    }
    
    /**
    *  @Route("/technicians/edit", name="edittechnician")
    */
    public function editTechnicianAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 2) {
            return $this->redirectToRoute('loginpage');
        }
        
        $username = $request->query->get('username');
        
        $stuff = json_decode(file_get_contents("http://192.168.33.11/users/username/".$username));
        
        if (count($stuff) < 1) {
            return $this->redirectToRoute('technicians');
        }
        
        $user_id = $stuff[0]->id;
        $role = $stuff[0]->role;
        
        return $this->render('AppBundle:Users:edittechnician.html.twig', array("user_id" => $user_id, "role" => $role, "username" => $username));
    }
    
    /**
    *  @Route("/technicians/edit/go")
    */
    public function editTechnicianGoAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 2) {
            return $this->redirectToRoute('loginpage');
        }
        
        $username = $request->request->get('username');
        $user_id = $request->request->get('user_id');
        $role = $request->request->get('role');
        
        if ($username != null && $user_id != null && $role != null) {
            $browser = $this->container->get('buzz');

            $json = json_encode([
                "name" => $username,
                "role" => "0"
            ]);

            $headers = ['Content-Type', 'application/json'];

            $browser->post('http://192.168.33.11/users/update/'.$user_id, $headers, $json);
        }
        
        return $this->redirectToRoute('technicians');
    }
    
    /**
    *  @Route("/technicians/delete/go")
    */
    public function deleteTechnicianGoAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 2) {
            return $this->redirectToRoute('loginpage');
        }
        
        $user_id = $request->request->get('user_id');
        
        if ($user_id != null) {
            $browser = $this->container->get('buzz');

            $headers = ['Content-Type', 'application/json'];

            $browser->post('http://192.168.33.11/users/delete/'.$user_id, $headers);
        }
        
        return $this->redirectToRoute('technicians');
    }
    
    /**
    *  @Route("/technicians/add", name="addtechnician")
    */
    public function addTechnicianAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 2) {
            return $this->redirectToRoute('loginpage');
        }
        
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 2) {
            return $this->redirectToRoute('loginpage');
        }
        
        return $this->render('AppBundle:Users:addtechnician.html.twig');
    }
    
    /**
    *  @Route("/technicians/add/go")
    */
    public function addTechnicianGoAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 2) {
            return $this->redirectToRoute('loginpage');
        }
        
        $username = $request->request->get('username');
        
        if ($username != null) {
            $browser = $this->container->get('buzz');

            $json = json_encode([
                "name" => $username,
                "role" => "0"
            ]);

            $headers = ['Content-Type', 'application/json'];

            $browser->post('http://192.168.33.11/users/add/', $headers, $json);
        }
        
        return $this->redirectToRoute('technicians');
    }
}
