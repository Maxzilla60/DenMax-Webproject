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
        $location_id = $request->request->get('location_id');
        
        if ($location_id == null) {
            $stuff = json_decode(file_get_contents("http://192.168.33.11/problems"));
        }
        else {
            $stuff = json_decode(file_get_contents("http://192.168.33.11/problems/location/".$location_id));
        }
        
        return $this->render('AppBundle:Problems:problems.html.twig', array("problems" => $stuff, "search" => $location_id));
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
        
        $technician_id = $request->request->get('technician_id');
        $problem_id = $request->request->get('problem_id');
        
        if ($technician_id != null && $problem_id != null) {
            $browser = $this->container->get('buzz');

            $json = json_encode([
                "technician" => $technician_id
            ]);

            $headers = ['Content-Type', 'application/json'];

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
        
        $problem_id = $request->request->get('problem_id');
        
        if ($problem_id != null) {
            $browser = $this->container->get('buzz');

            $browser->post('http://192.168.33.11/problems/deleteTechnician/'.$problem_id);
                
        return $this->redirectToRoute('problems');
        }
        
        return new Response($problem_id);
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
        
        $user_id = $request->getSession()->get('id');
        
        $stuff = json_decode(file_get_contents("http://192.168.33.11/problems/technician/".$user_id));
        
        return $this->render('AppBundle:Problems:myproblems.html.twig', array("problems" => $stuff));
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
        
        $problem_id = $request->query->get('problem_id');
        
        if ($problem_id != null) {
            $browser = $this->container->get('buzz');

            $browser->post('http://192.168.33.11/problems/fixProblem/'.$problem_id);
                
        return $this->redirectToRoute('myproblems');
        }
        
        return new Response($problem_id);
    }
}
