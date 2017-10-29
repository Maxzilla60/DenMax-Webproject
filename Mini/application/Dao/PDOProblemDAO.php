<?php

/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 27.10.17
 * Time: 09:37
 */
namespace Mini\Dao;

use Mini\Core\Model;
use Mini\Model\Problem;

class PDOProblemDAO extends Model
{
    function __construct(\PDO $connection = null)
    {
        if($connection != null){
            $this->db = $connection;
        } else {
            parent::__construct();
        }
    }

    public function getAllProblems() {
        try {
            $sql = "SELECT * FROM problems";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $query->execute();
            $fetchedProblems = $query->fetchAll(\PDO::FETCH_ASSOC);

            $problemsArray = array();
            if (count($fetchedProblems) > 0) {
                foreach ($fetchedProblems as $p) {
                    $problemsArray[] = new Problem($p['id'], $p['location_id'], $p['description'], $p['date'], $p['fixed'], $p['technician']);
                }
            }

            return $problemsArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }


    public function getProblemsByLocation($location_id) {
        try {
            $sql = "SELECT * FROM problems WHERE location_id = :location_id";
            $query = $this->db->prepare($sql);
            if ($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':location_id' => $location_id);
            $query->execute($parameters);
            $fetchedProblems = $query->fetchAll(\PDO::FETCH_ASSOC);

            $problemsArray = array();
            if (count($fetchedProblems) > 0) {
                foreach ($fetchedProblems as $p) {
                    $problemsArray[] = new Problem($p['id'], $p['location_id'], $p['description'], $p['date'], $p['fixed'], $p['technician']);
                }
            }

            return $problemsArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function getProblemsByTechnician($technician_id) {
        try {
            $sql = "SELECT * FROM problems WHERE technician = :technician";
            $query = $this->db->prepare($sql);
            if ($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':technician' => $technician_id);
            $query->execute($parameters);
            $fetchedProblems = $query->fetchAll(\PDO::FETCH_ASSOC);

            $problemsArray = array();
            if (count($fetchedProblems) > 0) {
                foreach ($fetchedProblems as $p) {
                    $problemsArray[] = new Problem($p['id'], $p['location_id'], $p['description'], $p['date'], $p['fixed'], $p['technician']);
                }
            }

            return $problemsArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function addProblem(Problem $problem) {
        try {
            $sql = "INSERT INTO problems (location_id, description, date, fixed, technician) VALUES (:location_id, :description, :date, :fixed, :technician)";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':location_id' => $problem->getLocationId(), ':description' => $problem->getDescription(), ':date' => $problem->getDate(), ':fixed' => $problem->getFixed(), ':technician' => $problem->getTechnician());

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            http_response_code(400);
            echo 'Exception!: ' . $exception->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function updateTechnician($problem_id, $technician) {
        try {
            $sql = "UPDATE problems SET technician = :technician WHERE id = :id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':technician' => $technician, ':id' => $problem_id);

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            http_response_code(400);
            echo 'Exception!: ' . $exception->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function deleteTechnician($problem_id) {
        try {
            $sql = "UPDATE problems SET technician = null WHERE id = :id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':id' => $problem_id);

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            http_response_code(400);
            echo 'Exception!: ' . $exception->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function fixProblem($problem_id) {
        try {
            $sql = "UPDATE problems SET fixed = '1' WHERE id = :id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':id' => $problem_id);

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            http_response_code(400);
            echo 'Exception!: ' . $exception->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }
}