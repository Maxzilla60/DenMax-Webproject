<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Repository\PDOProblemReactionRepository;
use Mini\View\ProblemReactionJsonView;

class ProblemreactionsController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDOProblemReactionRepository();
        }
        if(!isset($view)) {
            $this->view = new ProblemReactionJsonView();
        }

    }


    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        $problemreactions = $this->repository->getAllProblemReactions();
        $this->view->ShowAll($problemreactions);
    }

    /**
     * PAGE: problem
     * @param int $id
     */
    public function problem($id)
    {
        // load views
        $problemreactions = $this->repository->getProblemReactionsByProblemId($id);
        $this->view->ShowAll($problemreactions);
    }
}