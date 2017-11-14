<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

use AppBundle\Repository\StatusreportsRepo;

use AppBundle\Entity\Statusreports;
use AppBundle\Service\StatusreportsService;

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
     * @Route("/statusreports/old/csv", name="old_csv")
     */
    public function oldCSVAction() {
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

    /**
     * @Route("/statusreports/old/csv2", name="old_csv2")
     */
    public function oldCSV2Action() {
        $fetchedStatusreports = $this->repo->getAllStatusreports();

        $rows = array();
        $data = array("Id", "Location Id", "Status", "Date");
        $rows[] = implode(',', $data);
        foreach ($fetchedStatusreports as $report) {
            if ($report->status == "0") {
                $status = "GOOD";
            }
            else if ($report->status == "1") {
                $status = "AVARAGE";
            }
            else {
                $status = "BAD";
            }

            $data = array($report->id, $report->location_id, $status, $report->date);

            $rows[] = implode(',', $data);
        }

        $content = implode("\n", $rows);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="statusreports.csv"');

        return $response;
    }

    /**
     * @Route("/statusreports/doc", name="doc")
     */
    public function doctrineAction(StatusreportsService $statusreportsService) {
        /*$em = $this->getDoctrine()->getManager();
        $statusreports = $em->getRepository("AppBundle:Statusreports")->findAll();*/
        //$statusreportsService = $this->get("abcde");
        $statusreports = $statusreportsService->fetchAllStatusreports();

        //$statusreports = $this->getDoctrine()->getRepository("AppBundle:Statusreports")->findAll();
        return $this->render('AppBundle:Statusreports:doc.html.twig', array("statusreports" => $statusreports));
    }

    /**
     * @Route("/statusreports/csv", name="csv")
     */
    public function csvAction() {
        $fetchedStatusreports = $this->getDoctrine()->getRepository("AppBundle:Statusreports")->findAll();

        $rows = array();
        $data = array("Id", "Location Id", "Location Name", "Status", "Date");
        $rows[] = implode(',', $data);
        foreach ($fetchedStatusreports as $report) {
            if ($report->getStatus() == 0) {
                $status = "GOOD";
            }
            else if ($report->getStatus() == 1) {
                $status = "AVARAGE";
            }
            else {
                $status = "BAD";
            }

            $data = array($report->getId(), $report->getLocation()->getId(), $report->getLocation()->getName(), $status, $report->getDate()->format('d-m-Y H:i:s'));

            $rows[] = implode(',', $data);
        }
        $content = implode("\n", $rows);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="statusreports.csv"');

        return $response;
    }
}
