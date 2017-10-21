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
        // Checken of we inderdaad iets posten en of de body juist is ingesteld:
        if (isset($_POST['location_id']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['fixed'])) {
            // Technician is optioneel:
            if (isset($_POST['technician'])) {
                $technician = $_POST['technician'];
            }
            else {
                $technician = null;
            }

            $this->repository->addProblem(new Problem(0, $_POST['location_id'], $_POST['description'], $_POST['date'], $_POST['fixed'], $technician));
        }

        // Redirect
        header('location: ' . URL . 'problems');
    }

    /*
     * PAGE: updateTechnician
     */
    public function updateTechnician($problem_id) {
        // Checken of we inderdaad iets posten en of de body juist is ingesteld:
        if (isset($_POST['technician'])) {
            $this->repository->updateTechnician($problem_id, $_POST['technician']);
        }

        // Redirect
        header('location: ' . URL . 'problems');
    }

    /*
    * PAGE: deleteTechnician
    */
    public function deleteTechnician($problem_id) {
        $this->repository->deleteTechnician($problem_id);

        // Redirect
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
}