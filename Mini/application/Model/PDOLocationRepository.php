<?php

namespace Mini\Model;

use Mini\Core\Model;
use Location;
use StatusReport;

class PDOLocationRepository extends Model
{
    public function getAllLocations()
    {
        $sql = "SELECT * FROM locations";
        $query = $this->db->prepare($sql);
        $query->execute();
        $fetchedLocations = $query->fetchAll(PDO::FETCH_ASSOC);

        $locationsArray = array();
        if (count($fetchedLocations) > 0) {
            foreach ($fetchedLocations as $l) {
                $locationsArray[] = new Location($l['id'], $l['name'], $l['company_id']);
            }
        }

        return $locationsArray;
    }

    public function getStatusReport($location_id)
    {
        $sql = "SELECT * FROM statusreports WHERE location_id = :location_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':location_id' => $location_id);
        $query->execute($parameters);
        $fetchedReports = $query->fetchAll();

        $reportsArray = array();
        if (count($fetchedReports) > 0) {
            foreach ($fetchedReports as $r) {
                $reportsArray[] = new StatusReport($r['id'], $r['location_id'], $r['status'], $r['date']);
            }
        }

        return $reportsArray;
    }
    
    public function getProblem($location_id) {
        $sql = "SELECT * FROM problems WHERE location_id = :location_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':location_id' => $location_id);
        $query->execute($parameters);
        $fetchedProblems = $query->fetchAll();

        $problemsArray = array();
        if (count($fetchedProblems) > 0) {
            foreach ($fetchedProblems as $r) {

            }
        }

        return $problemsArray;
    }
}
