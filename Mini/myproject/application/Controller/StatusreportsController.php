<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Model\StatusReport;
use Mini\Repository\PDOStatusReportRepository;
use Mini\View\StatusReportJsonView;

class StatusreportsController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDOStatusReportRepository();
        }
        if(!isset($view)) {
            $this->view = new StatusReportJsonView();
        }

    }


    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        $statusreports = $this->repository->getAllStatusReports();
        $this->view->ShowAll($statusreports);
    }

    /**
     * PAGE: add
     */
    public function add() {
        // JSON ophalen en decoden:
        $input = file_get_contents('php://input');
        $inputJSON = json_decode($input, TRUE);

        // Checken of we de juiste data hebben meegekregen:
        if (isset($inputJSON['location_id']) && isset($inputJSON['status']) && isset($inputJSON['date'])) {
            $this->repository->addStatusReport(new StatusReport(0, $inputJSON['location_id'], $inputJSON['status'], $inputJSON['date']));
        }

        // Redirect (headers)
        header("access-control-allow-origin: *");
        header('location: ' . URL . 'statusreports', true, 200);
    }

    /**
     * PAGE: location
     * @param int $id
     */
    public function location($id)
    {
        // load views
        $statusreports = $this->repository->getStatusReportsByLocation($id);
        $this->view->ShowAll($statusreports);
    }
}