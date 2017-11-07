<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProblemsController extends Controller
{
    /**
    *  @Route("/problems", name="problems")
    */
    public function problemsAction(Request $request) {
        // Get location id for searching by location from POST variables:
        $location_id = $request->request->get('location_id');
        
        // Fetch Problems from API:
        if ($location_id == null) {
            $fetchedProblems = json_decode(file_get_contents("http://192.168.33.11/problems"));
        }
        // Search by location:
        else {
            $fetchedProblems = json_decode(file_get_contents("http://192.168.33.11/problems/location/".$location_id));
        }
        
        return $this->render('AppBundle:Problems:problems.html.twig', array("problems" => $fetchedProblems, "search" => $location_id));
    }
    
    /**
    *  @Route("/problems/technician", name="settechnician")
    */
    public function setTechnicianAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 1) {
            return $this->redirectToRoute('loginpage');
        }
        
        // Get problem id from POST variables
        $problem_id = $request->query->get('problem_id');
        
        return $this->render('AppBundle:Problems:settechnician.html.twig', array("problem_id" => $problem_id));
    }
    
    /**
    *  @Route("/problems/technician/go")
    *  Method("POST")
    */
    public function setTechnicianGoAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 1) {
            return $this->redirectToRoute('loginpage');
        }        
        
        // Get POST request variables:
        $technician_id = $request->request->get('technician_id');
        $problem_id = $request->request->get('problem_id');
        
        // Check if POST variables are set:
        if ($technician_id != null && $problem_id != null) {
            // Setup POST request to API:
            $browser = $this->container->get('buzz');
            // Build JSON payload:
            $json = json_encode([
                "technician" => $technician_id
            ]);
            // Set request header
            $headers = ['Content-Type', 'application/json'];
            // Send POST to API
            $browser->post('http://192.168.33.11/problems/updateTechnician/'.$problem_id, $headers, $json);
        }
        
        return $this->redirectToRoute('problems');
    }
    
    /**
    *  @Route("/problems/technician/delete")
    *  Method("POST")
    */
    public function deleteTechnicianAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 1) {
            return $this->redirectToRoute('loginpage');
        } 
        
        // Get problem id from POST variables
        $problem_id = $request->request->get('problem_id');
        
        // Check if POST variables are set:
        if ($problem_id != null) {
            // Setup POST request to API:
            $browser = $this->container->get('buzz');
            // Send POST to API
            $browser->post('http://192.168.33.11/problems/deleteTechnician/'.$problem_id);
        }
        
        return $this->redirectToRoute('problems');
    }
    
    /**
    *  @Route("/myproblems", name="myproblems")
    */
    public function myProblemsAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 0) {
            return $this->redirectToRoute('loginpage');
        }
        
        // Get technician's user id from POST variables
        $user_id = $request->getSession()->get('id');
        
        // Fetch all Problems for technician
        $fetchedProblems = json_decode(file_get_contents("http://192.168.33.11/problems/technician/".$user_id));
        
        return $this->render('AppBundle:Problems:myproblems.html.twig', array("problems" => $fetchedProblems));
    }
    
    /**
    *  @Route("/myproblems/fix", name="fixproblem")
    *  Method("POST")
    */
    public function fixProblemAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 0) {
            return $this->redirectToRoute('loginpage');
        }
        
        // Get technician's user id from POST variables
        $problem_id = $request->query->get('problem_id');
        // Check if problem id is set:
        if ($problem_id != null) {
            // Setup POST request to API:
            $browser = $this->container->get('buzz');
            // Send POST to API
            $browser->post('http://192.168.33.11/problems/fixProblem/'.$problem_id);
        }
        
        return $this->redirectToRoute('myproblems');
    }
}
