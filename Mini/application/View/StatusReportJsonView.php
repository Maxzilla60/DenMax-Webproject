<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:02
 */

namespace Mini\View;
use Mini\Model\StatusReport;


class StatusReportJsonView
{
    public function ShowAll(array $allStatusReports)
    {
        header('Content-Type: application/json');
        echo '[';
        for ($index = 0; $index < sizeof($allStatusReports); $index++) {
            $statusReport = $allStatusReports[$index];
            echo json_encode(['id' => $statusReport->getId(),
                'location_id' => $statusReport->getLocationId(),
                'status' => $statusReport->getStatus(),
                'date' => $statusReport->getDate()]);
            if ($index != sizeof($allStatusReports) - 1) {
                echo ',';
            }
        }
        echo ']';
    }


    public function ShowStatusReport(StatusReport $statusReport){
        header('Content-Type: application/json');
        echo json_encode(['id' => $statusReport->getId(),
            'location_id' => $statusReport->getLocationId(),
            'status' => $statusReport->getStatus(),
            'date' => $statusReport->getDate()]);
    }
}