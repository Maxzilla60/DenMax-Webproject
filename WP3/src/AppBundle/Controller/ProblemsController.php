<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Repository\ProblemsRepo;

class ProblemsController extends Controller
{
    private $repo;
    
    function __construct($repo = null)
    {
        if(!isset($repo)) {
            $this->repo = new ProblemsRepo();
        }
    }

    /**
     * @Route("/docproblem", name="docproblem")
     */
    public function doctineAction(Request $request){
        $problems = $this->getDoctrine()->getRepository("AppBundle:Problems")->findAll();
        return $this->render('AppBundle:Problems:doctrine.html.twig', array("problems" => $problems));
    }
    
    /**
    *  @Route("/problems", name="problems")
    */
    public function problemsAction(Request $request) {
        // Get location id for searching by location from POST variables:
        $location_id = $request->request->get('location_id');
        
        // Fetch Problems from API:
        if ($location_id == null) {
            $fetchedProblems = $this->repo->getAllProblems();
        }
        // Search by location:
        else {
            $fetchedProblems = $this->repo->getProblemsByLocation($location_id);
        }
        
        return $this->render('AppBundle:Problems:problems.html.twig', array("problems" => $fetchedProblems, "search" => $location_id));
    }
    
    /**
    *  @Route("/problems/technician", name="settechnician")
    *  @Method({"GET"})
    */
    public function setTechnicianAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 1) {
            return $this->redirectToRoute('loginpage');
        }
        
        // Get problem id from POST variables
        $problem_id = $request->query->get('problem_id');

        if ($problem_id == null) {
            return $this->redirectToRoute('problems');
        }

        // Fetch all Technicians from API
        $technicians = $this->repo->getUsersByRole(0);
        
        return $this->render('AppBundle:Problems:settechnician.html.twig', array("problem_id" => $problem_id, "technicians" => $technicians));
    }
    
    /**
    *  @Route("/problems/technician")
    *  @Method({"POST"})
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
            // Send POST to API:
            $this->repo->setBuzz($this->container->get('buzz'));
            $this->repo->updateTechnicianForProblem($technician_id, $problem_id);
        }
        
        return $this->redirectToRoute('problems');
    }
    
    /**
    *  @Route("/problems/technician/delete")
    *  @Method({"POST"})
    */
    public function deleteTechnicianAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 1) {
            return $this->redirectToRoute('loginpage');
        } 
        
        // Get problem id from POST variables
        $problem_id = $request->request->get('problem_id');

        if ($problem_id == null) {
            return $this->redirectToRoute('problems');
        }
        
        // Check if POST variables are set:
        if ($problem_id != null) {
            // Send POST to API:
            $this->repo->setBuzz($this->container->get('buzz'));
            $this->repo->deleteTechnicianFromProblem($problem_id);
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
        $fetchedProblems = $this->repo->getProblemsByTechnician($user_id);
        
        return $this->render('AppBundle:Problems:myproblems.html.twig', array("problems" => $fetchedProblems));
    }
    
    /**
    *  @Route("/myproblems/fix", name="fixproblem")
    *  @Method({"GET"})
    */
    public function fixProblemAction(Request $request) {
        // Check for logged in user and appropriate role:
        if ($request->getSession()->get('username') == null ||
           $request->getSession()->get('role') != 0) {
            return $this->redirectToRoute('loginpage');
        }
        
        // Get technician's user id from POST variables
        $problem_id = $request->query->get('problem_id');

        if ($problem_id == null) {
            return $this->redirectToRoute('myproblems');
        }

        // Check if problem id is set:
        if ($problem_id != null) {
            // Send POST to API:
            $this->repo->setBuzz($this->container->get('buzz'));
            $this->repo->fixProblem($problem_id);
        }
        
        return $this->redirectToRoute('myproblems');
    }

    /**
     * Export to PDF
     *
     * @Route("/pdf", name="acme_demo_pdf")
     */
    public function pdfAction()
    {
        $problems = $this->getDoctrine()->getRepository("AppBundle:Problems")->findAll();
        $html = $this->renderView('AppBundle:Problems:doctrine.html.twig', array("problems" => $problems));

        $filename = sprintf('test-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }
}
