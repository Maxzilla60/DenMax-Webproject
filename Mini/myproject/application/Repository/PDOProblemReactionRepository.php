<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 10.10.17
 * Time: 16:51
 */

namespace Mini\Repository;

use Mini\Core\Model;
use Mini\Dao\PDOProblemReactionDAO;
use Mini\Model\ProblemReaction;

class PDOProblemReactionRepository
{
    private $problemReactionsDAO;

    public function __construct(PDOProblemReactionDAO $problemReactionsDAO)
    {
        $this->problemReactionsDAO = $problemReactionsDAO;
    }

    public function getAllProblemReactions()
    {
        $problemReactions = $this->problemReactionsDAO->getAllProblemReactions();
        return $problemReactions;
    }

    public function getProblemReactionsByProblemId($problem_id)
    {
        $problemReactions = null;
        if($this->isValidId($problem_id)) {
            $problemReactions = $this->problemReactionsDAO->getProblemReactionsByProblemId($problem_id);
        }
        return $problemReactions;
    }

    public function addProblemReaction(ProblemReaction $problemReaction) {
        $this->problemReactionsDAO->addProblemReaction($problemReaction);
    }

    private function isValidId($id)
    {
        if (is_string($id) && ctype_digit(trim($id))) {
            $id=(int)$id;
        }
        return is_integer($id) and $id >= 0;
    }
}