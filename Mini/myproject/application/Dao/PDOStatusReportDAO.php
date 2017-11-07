<?php

/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 27.10.17
 * Time: 10:09
 */
namespace Mini\Dao;

use Mini\Core\Model;
use Mini\Model\StatusReport;

class PDOStatusReportDAO extends Model
{
    function __construct(\PDO $connection = null)
    {
        if($connection != null){
            $this->db = $connection;
        } else {
            parent::__construct();
        }
    }

    public function getAllStatusReports() {
        try {
            $sql = "SELECT * FROM statusreports";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $query->execute();
            $fetchedReports = $query->fetchAll(\PDO::FETCH_ASSOC);

            $reportsArray = array();
            if (count($fetchedReports) > 0) {
                foreach ($fetchedReports as $r) {
                    $reportsArray[] = new StatusReport($r['id'], $r['location_id'], $r['status'], $r['date']);
                }
            }

            return $reportsArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function getStatusReportsById($id) {
        try {
            $sql = "SELECT * FROM statusreports WHERE id = :id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':id' => $id);
            $query->execute($parameters);
            $fetchedReports = $query->fetchAll(\PDO::FETCH_ASSOC);

            $reportsArray = array();
            if (count($fetchedReports) > 0) {
                foreach ($fetchedReports as $r) {
                    $reportsArray[] = new StatusReport($r['id'], $r['location_id'], $r['status'], $r['date']);
                }
            }

            return $reportsArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function getStatusReportsByLocation($location_id) {
        try {
            $sql = "SELECT * FROM statusreports WHERE location_id = :location_id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
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
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function addStatusReport(StatusReport $statusReport) {
        try {
            $sql = "INSERT INTO statusreports (location_id, status, date) VALUES (:location_id, :status, :date)";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':location_id' => $statusReport->getLocationId(), ':status' => $statusReport->getStatus(), ':date' => $statusReport->getDate());

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            http_response_code(400);
            //echo 'Exception!: ' . $exception->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }
}