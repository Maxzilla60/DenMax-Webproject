<?php

namespace Mini\Repository;

use Mini\Dao\PDOStatusReportDAO;
use Mini\Model\StatusReport;

class PDOStatusReportRepository
{
    private $statusReportDAO;

    public function __construct(PDOStatusReportDAO $statusReportDAO)
    {
        $this->statusReportDAO = $statusReportDAO;
    }

    public function getAllStatusReports() {
        $statusReports = $this->statusReportDAO->getAllStatusReports();
        return $statusReports;
    }

    public function getStatusReportsById($id) {
        $statusReports = $this->statusReportDAO->getStatusReportsById($id);
        return $statusReports;
    }

    public function getStatusReportsByLocation($location_id) {
        $statusReports = null;
        if($this->isValidId($location_id)) {
            $statusReports = $this->statusReportDAO->getStatusReportsByLocation($location_id);
        }
        return $statusReports;
    }

    public function addStatusReport(StatusReport $statusReport) {
        $this->statusReportDAO->addStatusReport($statusReport);
    }

    private function isValidId($id)
    {
        if (is_string($id) && ctype_digit(trim($id))) {
            $id=(int)$id;
        }
        return is_integer($id) and $id >= 0;
    }
}
