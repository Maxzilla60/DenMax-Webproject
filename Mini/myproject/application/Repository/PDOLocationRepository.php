<?php

namespace Mini\Repository;

use Mini\Dao\PDOLocationDAO;
use Mini\Model\Location;

class PDOLocationRepository
{
    private $locationDAO;

    public function __construct(PDOLocationDAO $locationDAO)
    {
        $this->locationDAO = $locationDAO;
    }

    public function getAllLocations() {
        $locations = $this->locationDAO->getAllLocations();
        return $locations;
    }

    public function getLocationsByCompany($company_id) {
        $locations = null;
        if($this->isValidId($company_id)) {
            $locations = $this->locationDAO->getLocationsByCompany($company_id);
        }
        return $locations;
    }

    public function addLocation(Location $location) {
        $this->locationDAO->addLocation($location);
    }

    private function isValidId($id)
    {
        if (is_string($id) && ctype_digit(trim($id))) {
            $id=(int)$id;
        }
        return is_integer($id) and $id >= 0;
    }
}
