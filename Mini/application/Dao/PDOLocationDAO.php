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
        parent::__construct();
        if($connection != null){
            $this->db = $connection;
        }
    }

    public function getAllLocations() {
        $sql = "SELECT * FROM locations";
        $query = $this->db->prepare($sql);
        $query->execute();
        $fetchedLocations = $query->fetchAll(\PDO::FETCH_ASSOC);

        $locationsArray = array();
        if (count($fetchedLocations) > 0) {
            foreach ($fetchedLocations as $l) {
                $locationsArray[] = new Location($l['id'], $l['name'], $l['company_id']);
            }
        }

        return $locationsArray;
    }

    public function getLocationsByCompany($company_id) {
        $sql = "SELECT * FROM locations WHERE company_id = :company_id";
        $query = $this->db->prepare($sql);
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
    }

    public function addLocation(Location $location) {
        try {
            $sql = "INSERT INTO locations (name, company_id) VALUES (:name, :company_id)";
            $query = $this->db->prepare($sql);
            $parameters = array(':name' => $location->getName(), ':company_id' => $location->getCompanyId());

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo 'Exception!: ' . $e->getMessage();
        }
    }
}