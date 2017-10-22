<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Model\Problem;
use Mini\Repository\PDOProblemRepository;
use Mini\View\ProblemJsonView;

class ProblemsController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDOProblemRepository();
        }
        if(!isset($view)) {
            $this->view = new ProblemJsonView();
        }

    }


    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        $problems = $this->repository->getAllProblems();
        $this->view->ShowAll($problems);
    }

    /**
     * PAGE: add
     */
    public function add() {
        // JSON ophalen en decoden:
        $input = file_get_contents('php://input');
        $inputJSON = json_decode($input, TRUE);

        // Checken of we de juiste data hebben meegekregen:
        if (isset($inputJSON['location_id']) && isset($inputJSON['description']) && isset($inputJSON['date']) && isset($inputJSON['fixed'])) {
            // Technician is optioneel:
            if (isset($inputJSON['technician'])) {
                $technician = $inputJSON['technician'];
            }
            else {
                $technician = null;
            }

            $this->repository->addProblem(new Problem(0, $inputJSON['location_id'], $inputJSON['description'], $inputJSON['date'], $inputJSON['fixed'], $technician));
        }

        // Redirect (headers)
        header("access-control-allow-origin: *");
        header('location: ' . URL . 'problems');
    }

    /*
     * PAGE: updateTechnician
     */
    public function updateTechnician($problem_id) {
        // JSON ophalen en decoden:
        $input = file_get_contents('php://input');
        $inputJSON = json_decode($input, TRUE);

        // Checken of we de juiste data hebben meegekregen:
        if (isset($inputJSON['technician'])) {
            $this->repository->updateTechnician($problem_id, $inputJSON['technician']);
        }

        // Redirect (headers)
        header("access-control-allow-origin: *");
        header('location: ' . URL . 'problems');
    }

    /*
    * PAGE: deleteTechnician
    */
    public function deleteTechnician($problem_id) {
        $this->repository->deleteTechnician($problem_id);

        // Redirect (headers)
        header("access-control-allow-origin: *");
        header('location: ' . URL . 'problems');
    }

    /**
     * PAGE: location
     * @param int $id
     */
    public function location($id)
    {
        // load views
        $problems = $this->repository->getProblemsByLocation($id);
        $this->view->ShowAll($problems);
    }

    /**
     * PAGE: technician
     * @param int $id
     */
    public function technician($id)
    {
        // load views
        $problems = $this->repository->getProblemsByTechnician($id);
        $this->view->ShowAll($problems);
    }
}