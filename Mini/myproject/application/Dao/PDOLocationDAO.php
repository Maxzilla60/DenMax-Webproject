<?php

/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 27.10.17
 * Time: 09:22
 */

namespace Mini\Dao;

use Mini\Core\Model;
use Mini\Model\Location;

class PDOLocationDAO extends Model
{
    function __construct(\PDO $connection = null)
    {
        if($connection != null){
            $this->db = $connection;
        } else {
            parent::__construct();
        }
    }

    public function getAllLocations() {
        try {
            $sql = "SELECT * FROM locations";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $query->execute();
            $fetchedLocations = $query->fetchAll(\PDO::FETCH_ASSOC);

            $locationsArray = array();
            if (count($fetchedLocations) > 0) {
                foreach ($fetchedLocations as $l) {
                    $locationsArray[] = new Location($l['id'], $l['name'], $l['company_id']);
                }
            }
            return $locationsArray;

        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function getLocationsByCompany($company_id) {
        try {
            $sql = "SELECT * FROM locations WHERE company_id = :company_id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':company_id' => $company_id);
            $query->execute($parameters);
            $fetchedLocations = $query->fetchAll(\PDO::FETCH_ASSOC);

            $locationsArray = array();
            if (count($fetchedLocations) > 0) {
                foreach ($fetchedLocations as $l) {
                    $locationsArray[] = new Location($l['id'], $l['name'], $l['company_id']);
                }
            }

            return $locationsArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function addLocation(Location $location) {
        try {
            $sql = "INSERT INTO locations (name, company_id) VALUES (:name, :company_id)";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':name' => $location->getName(), ':company_id' => $location->getCompanyId());

            $query->execute($parameters);
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }
}