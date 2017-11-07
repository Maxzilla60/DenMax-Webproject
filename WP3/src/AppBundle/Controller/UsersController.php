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
        
        // Fetch all technicians from API
        $fetchedTechnicians = json_decode(file_get_contents("http://192.168.33.11/users/role/0"));
        
        return $this->render('AppBundle:Users:technicians.html.twig', array("users" => $fetchedTechnicians));
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
        
        // Get username from GET variables
        $username = $request->query->get('username');
        
        // Fetch user data
        $fetchedUsers = json_decode(file_get_contents("http://192.168.33.11/users/username/".$username));
        // Check if user exists:
        if (count($fetchedUsers) < 1) {
            return $this->redirectToRoute('technicians');
        }
        
        $user_id = $fetchedUsers[0]->id;
        $role = $fetchedUsers[0]->role;
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
        
        // Get POST request variables:
        $username = $request->request->get('username');
        $user_id = $request->request->get('user_id');
        $role = $request->request->get('role');
        
        // Check if POST variables are set:
        if ($username != null && $user_id != null && $role != null) {
            // Setup POST request to API:
            $browser = $this->container->get('buzz');
            // Build JSON payload:
            $json = json_encode([
                "name" => $username,
                "role" => "0"
            ]);
            // Set request headers
            $headers = ['Content-Type', 'application/json'];
            // Send POST to API
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
        // Get user id from POST request variables
        $user_id = $request->request->get('user_id');
        // Check if user id is set:
        if ($user_id != null) {
            // Setup POST request to API:
            $browser = $this->container->get('buzz');
            // Send POST to API
            $browser->post('http://192.168.33.11/users/delete/'.$user_id);
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
        
        // Get username from POST request variables
        $username = $request->request->get('username');
        // Check if username is set:
        if ($username != null) {
            // Setup POST request to API:
            $browser = $this->container->get('buzz');
            // Build JSON payload:
            $json = json_encode([
                "name" => $username,
                "role" => "0"
            ]);
            // Set request headers
            $headers = ['Content-Type', 'application/json'];
            // Send POST to API
            $browser->post('http://192.168.33.11/users/add/', $headers, $json);
        }
        
        return $this->redirectToRoute('technicians');
    }
}
