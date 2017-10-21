<?php

namespace Mini\Repository;

use Mini\Core\Model;
use Mini\Model\Location;

class PDOLocationRepository extends Model
{
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
