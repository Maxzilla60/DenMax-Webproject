<?php

namespace Mini\Model;

use Mini\Core\Model;

class PDOStatusReportRepository extends Model
{
    public function getAllStatusReports() {
        $sql = "SELECT * FROM statusreports";
        $query = $this->db->prepare($sql);
        $query->execute();
        $fetchedReports = $query->fetchAll(\PDO::FETCH_ASSOC);

        $reportsArray = array();
        if (count($fetchedReports) > 0) {
            foreach ($fetchedReports as $r) {
                $reportsArray[] = new StatusReport($r['id'], $r['location_id'], $r['status'], $r['date']);
            }
        }

        return $reportsArray;
    }

    public function getStatusReportsByLocation($location_id) {
        $sql = "SELECT * FROM statusreports WHERE location_id = :location_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':location_id' => $location_id);
        $query->execute($parameters);
        $fetchedReports = $query->fetchAll(\PDO::FETCH_ASSOC);

        $reportsArray = array();
        if (count($fetchedReports) > 0) {
            foreach ($fetchedReports as $r) {
                $reportsArray[] = new StatusReport($r['id'], $r['location_id'], $r['status'], $r['date']);
            }
        }

        return $reportsArray;
    }
}
