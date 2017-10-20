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
        // Checken of we inderdaad iets posten en of de body juist is ingesteld:
        if (isset($_POST['location_id']) && isset($_POST['status']) && isset($_POST['date'])) {
            $this->repository->addStatusReport(new StatusReport(0, $_POST['location_id'], $_POST['status'], $_POST['date']));
        }

        // Redirect
        header('location: ' . URL . 'statusreports');
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