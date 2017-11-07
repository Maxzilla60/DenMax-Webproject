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
        
        $stuff = json_decode(file_get_contents("http://192.168.33.11/locations/company/".$company_id));
        
        return $this->render('AppBundle:Locations:locations.html.twig', array("locations" => $stuff));
    }
    
    /**
    *   @Route("/locations/add", name="addlocation")
    */
    public function addAction() {
        return $this->render('AppBundle:Locations:add.html.twig');
    }
}
