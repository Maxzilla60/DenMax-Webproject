<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class StatusreportsController extends Controller
{
    /**
    *  @Route("/statusreports", name="statusreports")
    */
    public function statusreportsAction(Request $request) {
        $location_id = $request->request->get('location_id');
        
        if ($location_id == null) {
            $stuff = json_decode(file_get_contents("http://192.168.33.11/statusreports"));
        }
        else {
            $stuff = json_decode(file_get_contents("http://192.168.33.11/statusreports/location/".$location_id));
        }
        
        return $this->render('AppBundle:Statusreports:statusreports.html.twig', array("statusreports" => $stuff, "search" => $location_id));
    }
}
