<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:41
 */

namespace Mini\View;

use Mini\Model\Location;


class LocationJsonView
{
    public function ShowAll(array $allLocations)
    {
        header('Content-Type: application/json');
        echo '[';
        for ($index = 0; $index < sizeof($allLocations); $index++) {
            $location = $allLocations[$index];
            echo json_encode(['id' => $location->getId(),
                'name' => $location->getName(),
                'company_id' => $location->getCompanyId()]);
            if ($index != sizeof($allLocations) - 1) {
                echo ',';
            }
        }
        echo ']';
    }


    public function ShowLocation(Location $location){
        header('Content-Type: application/json');
        echo json_encode(['id' => $location->getId(),
            'name' => $location->getName(),
            'company_id' => $location->getCompanyId()]);
    }
}