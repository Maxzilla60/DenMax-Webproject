<?php

namespace Mini\Repository;

use Mini\Core\Model;
use Mini\Model\Problem;

class PDOProblemRepository extends Model
{
    public function getAllProblems() {
        $sql = "SELECT * FROM problems";
        $query = $this->db->prepare($sql);
        $query->execute();
        $fetchedProblems = $query->fetchAll(\PDO::FETCH_ASSOC);

        $problemsArray = array();
        if (count($fetchedProblems) > 0) {
            foreach ($fetchedProblems as $p) {
                $problemsArray[] = new Problem($p['id'], $p['location_id'], $p['description'], $p['date'], $p['fixed'], $p['technician']);
            }
        }

        return $problemsArray;
    }


    public function getProblemsByLocation($location_id) {
        $sql = "SELECT * FROM problems WHERE location_id = :location_id";
        $query = $this->db->prepare($sql);
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
    }

    public function addProblem(Problem $problem) {
        try {
            $sql = "INSERT INTO problems (location_id, description, date, fixed, technician) VALUES (:location_id, :description, :date, :fixed, :technician)";
            $query = $this->db->prepare($sql);
            $parameters = array(':location_id' => $problem->getLocationId(), ':description' => $problem->getDescription(), ':date' => $problem->getDate(), ':fixed' => $problem->getFixed(), ':technician' => $problem->getTechnician());

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo 'Exception!: ' . $e->getMessage();
        }
    }

    public function updateTechnician($problem_id, $technician) {
        try {
            $sql = "UPDATE problems SET technician = :technician WHERE id = :id";
            $query = $this->db->prepare($sql);
            $parameters = array(':technician' => $technician, ':id' => $problem_id);

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo 'Exception!: ' . $e->getMessage();
        }
    }

    public function deleteTechnician($problem_id) {
        try {
            $sql = "UPDATE problems SET technician = null WHERE id = :id";
            $query = $this->db->prepare($sql);
            $parameters = array(':id' => $problem_id);

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo 'Exception!: ' . $e->getMessage();
        }
    }
}
