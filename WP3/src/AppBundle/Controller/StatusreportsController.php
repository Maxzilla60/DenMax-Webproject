<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
    
    /**
     * @Route("/statusreports/csv", name="csv")
     */
    public function statusreportsCSVAction() {
        $response = new StreamedResponse();
        $response->setCallback(function() {
            $handle = fopen('php://output', 'w+');    
            fputcsv($handle, array('ID', 'Location ID', 'Status', 'Date'),',');

            $stuff = json_decode(file_get_contents("http://192.168.33.11/statusreports"));
            
            foreach ($stuff as $s) {
                if ($s->status == "0") {
                    $status = "GOOD";
                }
                else if ($s->status == "1") {
                    $status = "AVARAGE";
                }
                else {
                    $status = "BAD";
                }
                
                fputcsv(
                    $handle,
                    array(
                        $s->id,
                        $s->location_id,
                        $status,
                        $s->date,
                    ),
                    ','
                );
            }
            
            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="statusreports.csv"');

        return $response;
    }
}
