<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Repository\UsersRepo;

class UsersController extends Controller
{
    private $repo;
    
    function __construct($repo = null)
    {
        if(!isset($repo)) {
            $this->repo = new UsersRepo();
        }
    }

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
        $fetchedTechnicians = $this->repo->getUsersByRole(0);
        
        return $this->render('AppBundle:Users:technicians.html.twig', array("users" => $fetchedTechnicians));
    }
    
    /**
    *  @Route("/technicians/edit", name="edittechnician")
    *  @Method({"GET"})
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
        $fetchedUsers = $this->repo->getUserByUsername($username);
        // Check if user exists:
        if (count($fetchedUsers) < 1) {
            return $this->redirectToRoute('technicians');
        }
        
        $user_id = $fetchedUsers[0]->id;
        $role = $fetchedUsers[0]->role;
        return $this->render('AppBundle:Users:edittechnician.html.twig', array("user_id" => $user_id, "role" => $role, "username" => $username));
    }
    
    /**
    *  @Route("/technicians/edit")
    *  @Method({"POST"})
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
            // Send POST to API:
            $this->repo->setBuzz($this->container->get('buzz'));
            $this->repo->updateTechnician($user_id, $username, $role);
        }
        
        return $this->redirectToRoute('technicians');
    }
    
    /**
    *  @Route("/technicians/delete")
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
            // Send POST to API:
            $this->repo->setBuzz($this->container->get('buzz'));
            $this->repo->deleteUser($user_id);
        }
        
        return $this->redirectToRoute('technicians');
    }
    
    /**
    *  @Route("/technicians/add", name="addtechnician")
    *  @Method({"GET"})
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
    *  @Route("/technicians/add")
    *  @Method({"POST"})
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
            // Send POST to API:
            $this->repo->setBuzz($this->container->get('buzz'));
            $this->repo->addTechnician($username);
        }
        
        return $this->redirectToRoute('technicians');
    }
}
