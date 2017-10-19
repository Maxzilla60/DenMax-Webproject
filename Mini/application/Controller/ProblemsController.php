<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Model\PDOProblemRepository;
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
        $locations = $this->repository->getAllProblems();
        $this->view->ShowAll($locations);
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