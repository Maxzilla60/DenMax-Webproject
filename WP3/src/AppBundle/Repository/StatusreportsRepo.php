<?php

namespace AppBundle\Repository;

class StatusreportsRepo {
    public function getAllStatusreports() {
        return json_decode(file_get_contents("http://192.168.33.11/statusreports"));
    }
    
    public function getStatusreportsByLocation($location_id) {
        return json_decode(file_get_contents("http://192.168.33.11/statusreports/location/".$location_id));
    }
}