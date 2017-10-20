<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 10.10.17
 * Time: 16:51
 */

namespace Mini\Repository;

use Mini\Core\Model;
use Mini\Model\ProblemReaction;

class PDOProblemReactionRepository extends Model
{
    public function getAllProblemReactions()
    {
        $sql = "SELECT * FROM problemreactions";
        $query = $this->db->prepare($sql);
        $query->execute();
        $fetchedProblemReactions = $query->fetchAll(\PDO::FETCH_ASSOC);

        $problemReactionArray = array();
        if (count($fetchedProblemReactions) > 0) {
            foreach ($fetchedProblemReactions as $pr) {
                $problemReactionArray[] = new ProblemReaction($pr['id'], $pr['problem_id'], $pr['rating'], $pr['description']);
            }
        }

        return $problemReactionArray;
    }

    public function getProblemReactionsByProblemId($problem_id)
    {
        $sql = "SELECT * FROM problemreactions WHERE problem_id = :problem_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':problem_id' => $problem_id);
        $query->execute($parameters);
        $fetchedProblemReactions = $query->fetchAll(\PDO::FETCH_ASSOC);

        $problemReactionArray = array();
        if (count($fetchedProblemReactions) > 0) {
            foreach ($fetchedProblemReactions as $pr) {
                $problemReactionArray[] = new ProblemReaction($pr['id'], $pr['problem_id'], $pr['rating'], $pr['description']);
            }
        }

        return $problemReactionArray;
    }
}