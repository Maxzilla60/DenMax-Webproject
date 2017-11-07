<?php

/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 27.10.17
 * Time: 09:22
 */
namespace Mini\Dao;

use Mini\Core\Model;
use Mini\Model\ProblemReaction;

class PDOProblemReactionDAO extends Model
{
    function __construct(\PDO $connection = null)
    {
        if($connection != null){
            $this->db = $connection;
        } else {
            parent::__construct();
        }
    }

    public function getAllProblemReactions()
    {
        try {
            $sql = "SELECT * FROM problemreactions";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $query->execute();
            $fetchedProblemReactions = $query->fetchAll(\PDO::FETCH_ASSOC);

            $problemReactionArray = array();
            if (count($fetchedProblemReactions) > 0) {
                foreach ($fetchedProblemReactions as $pr) {
                    $problemReactionArray[] = new ProblemReaction($pr['id'], $pr['problem_id'], $pr['rating'], $pr['description']);
                }
            }

            return $problemReactionArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function getProblemReactionsById($id) {
        try {
            $sql = "SELECT * FROM problemreactions WHERE id = :id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':id' => $id);
            $query->execute($parameters);
            $fetchedProblemReactions = $query->fetchAll(\PDO::FETCH_ASSOC);

            $problemReactionArray = array();
            if (count($fetchedProblemReactions) > 0) {
                foreach ($fetchedProblemReactions as $pr) {
                    $problemReactionArray[] = new ProblemReaction($pr['id'], $pr['problem_id'], $pr['rating'], $pr['description']);
                }
            }

            return $problemReactionArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function getProblemReactionsByProblemId($problem_id)
    {
        try {
            $sql = "SELECT * FROM problemreactions WHERE problem_id = :problem_id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
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
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }


    }

    public function addProblemReaction(ProblemReaction $problemReaction) {
        try {
            $sql = "INSERT INTO problemreactions (problem_id, description, rating) VALUES (:problem_id, :description, :rating)";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':problem_id' => $problemReaction->getProblemId(), ':description' => $problemReaction->getDescription(), ':rating' => $problemReaction->getRating());

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            http_response_code(400);
            //echo 'Exception!: ' . $e->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }
}