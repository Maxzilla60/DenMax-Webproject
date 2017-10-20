<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

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