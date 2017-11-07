<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Dao\DaoException;
use Mini\Dao\PDOProblemReactionDAO;
use Mini\Model\ProblemReaction;
use Mini\Repository\PDOProblemReactionRepository;
use Mini\View\ProblemReactionJsonView;

class ProblemreactionsController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDOProblemReactionRepository(new PDOProblemReactionDAO());
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
     * PAGE: id
     */
    public function id($id)
    {
        // load views
        $problemreactions = $this->repository->getProblemReactionsById($id);
        $this->view->ShowAll($problemreactions);
    }

    /*
     * PAGE; add
     */
    public function add($problem_id) {
        try {
            // JSON ophalen en decoden:
            $input = file_get_contents('php://input');
            $inputJSON = json_decode($input, TRUE);

            // Checken of we de juiste data hebben meegekregen:
            if (isset($inputJSON['description']) && isset($inputJSON['rating'])) {
                $this->repository->addProblemReaction(new ProblemReaction(0, $problem_id, $inputJSON['rating'], $inputJSON['description']));
                http_response_code(200);
            } else {
                http_response_code(400);
                echo 'wrong input';
            }

            // Redirect (headers)
            header("access-control-allow-origin: *");
            header('location: ' . URL . 'problemreactions/problem/' . $problem_id, true, 200);
        } catch (DaoException $exception) {
            http_response_code(400);
            echo $exception;
        }
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