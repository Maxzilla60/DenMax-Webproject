<?php

namespace Mini\Model;

use Mini\Core\Model;

class PDOProblemRepository extends Model
{
    public function getProblemsByLocation($location_id) {
        $sql = "SELECT * FROM problems WHERE location_id = :location_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':location_id' => $location_id);
        $query->execute($parameters);
        $fetchedProblems = $query->fetchAll();

        $problemsArray = array();
        if (count($fetchedProblems) > 0) {
            foreach ($fetchedProblems as $p) {
                $problemsArray[] = new Problem($p['id'], $p['location_id'], $p['description'], $p['date'], $p['fixed'], $p['technician']);
            }
        }

        return $problemsArray;
    }
}
