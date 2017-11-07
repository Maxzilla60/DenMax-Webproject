<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LocationsController extends Controller
{
    /**
    *  @Route("/locations", name="locations")
    */
    public function locationsAction(Request $request) {
        // Get the user's company from the session
        $company_id = $request->getSession()->get('company_id');
        
        // Check for logged in user and whether it works under a company:
        if ($company_id == null) {
            return $this->redirectToRoute('home');
        }
        
        // Fetch locations from API
        $fetchedLocations = json_decode(file_get_contents("http://192.168.33.11/locations/company/".$company_id));
        
        return $this->render('AppBundle:Locations:locations.html.twig', array("locations" => $fetchedLocations));
    }
    
    /**
    *   @Route("/locations/add", name="addlocation")
    */
    public function addAction() {
        // Get the user's company from the session
        $company_id = $request->getSession()->get('company_id');
        // Check for logged in user and whether it works under a company:
        if ($company_id == null) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('AppBundle:Locations:add.html.twig');
    }
    
    /**
    *  @Route("/locations/add/go")
    */
    public function addLocationGoAction(Request $request) {
        // Get the user's company from the session
        $company_id = $request->getSession()->get('company_id');
        // Check for logged in user and whether it works under a company:
        if ($company_id == null) {
            return $this->redirectToRoute('home');
        }
        
        // Get POST request variables:
        $name = $request->request->get('name');
        $company_id = $request->getSession()->get('company_id');
        
        // Check if all POST variables are set
        if ($name != null && $company_id != null) {
            // Setup POST request to API:
            $browser = $this->container->get('buzz');
            // Build JSON payload
            $json = json_encode([
                "name" => $name,
                "company_id" => $company_id
            ]);
            // Set request header
            $headers = ['Content-Type', 'application/json'];
            // Send POST to API
            $browser->post('http://192.168.33.11/locations/add/', $headers, $json);
        }
        
        return $this->redirectToRoute('locations');
    }
}
