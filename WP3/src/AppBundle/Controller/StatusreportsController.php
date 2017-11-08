<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

use AppBundle\Repository\StatusreportsRepo;

class StatusreportsController extends Controller
{
    private $repo;
    
    function __construct($repo = null)
    {
        if(!isset($repo)) {
            $this->repo = new StatusreportsRepo();
        }
    }
    
    /**
    *  @Route("/statusreports", name="statusreports")
    */
    public function statusreportsAction(Request $request) {
        // Get location id for searching by location from POST variables:
        $location_id = $request->request->get('location_id');
        
        // Fetch Statusreports from API:
        if ($location_id == null) {
            $fetchedStatusreports = $this->repo->getAllStatusreports();
        }
        // Search by location:
        else {
            $fetchedStatusreports = $this->repo->getStatusreportsByLocation($location_id);
        }
        
        return $this->render('AppBundle:Statusreports:statusreports.html.twig', array("statusreports" => $fetchedStatusreports, "search" => $location_id));
    }
    
    /**
     * @Route("/statusreports/csv", name="csv")
     */
    public function statusreportsCSVAction() {
        // Create new response
        $response = new StreamedResponse();
        // Set callback function to create file:
        $response->setCallback(function() {
            // Open new CSV file stream:
            $handle = fopen('php://output', 'w+');
            // Set top values 
            fputcsv($handle, array('Id', 'Location Id', 'Status', 'Date'),',');

            // Fetch Statusreports from API:
            $fetchedStatusreports = $this->repo->getAllStatusreports();
            
            // Fill file with values:
            foreach ($fetchedStatusreports as $s) {
                // Put status in nice words:
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

        // Set headers:
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="statusreports.csv"');

        return $response;
    }
}
