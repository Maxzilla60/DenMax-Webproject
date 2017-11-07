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
        $company_id = $request->getSession()->get('company_id');
        
        // Check for logged in user and whether it works under a company:
        if ($company_id == null) {
            return $this->redirectToRoute('home');
        }
        
        $stuff = json_decode(file_get_contents("http://192.168.33.11/locations/company/".$company_id));
        
        return $this->render('AppBundle:Locations:locations.html.twig', array("locations" => $stuff));
    }
    
    /**
    *   @Route("/locations/add", name="addlocation")
    */
    public function addAction() {
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
        $company_id = $request->getSession()->get('company_id');
        // Check for logged in user and whether it works under a company:
        if ($company_id == null) {
            return $this->redirectToRoute('home');
        }
        
        $name = $request->request->get('name');
        $company_id = $request->getSession()->get('company_id');
        
        if ($name != null && $company_id != null) {
            $browser = $this->container->get('buzz');

            $json = json_encode([
                "name" => $name,
                "company_id" => $company_id
            ]);

            $headers = ['Content-Type', 'application/json'];

            $browser->post('http://192.168.33.11/locations/add/', $headers, $json);
        }
        
        return $this->redirectToRoute('locations');
    }
}
