<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

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