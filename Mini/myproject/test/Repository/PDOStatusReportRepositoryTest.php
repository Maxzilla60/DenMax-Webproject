<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 00:41
 */

use Mini\Repository\PDOStatusReportRepository;
use PHPUnit\Framework\TestCase;
use Mini\Model\StatusReport;

class PDOStatusReportRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->mockUserDAO = $this->getMockBuilder('Mini\Dao\PDOStatusReportDAO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->mockUserDAO = null;
    }

    public function testGetAll_StatusReportArray()
    {
        $statusReports = [];
        for ($i = 0; $i<5; $i++){
            $statusReports[] = new StatusReport($i, $i, 1, "10-10-2010");
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getAllStatusReports')
            ->will($this->returnValue($statusReports));
        $statusReportRepository = new PDOStatusReportRepository($this->mockUserDAO);
        $actualStatusReports = $statusReportRepository->getAllStatusReports();
        $this->assertEquals($statusReports, $actualStatusReports);
    }

    public function testGetByLocation_IdExists_StatusReportArray()
    {
        $location_id = "2";
        $statusReports = [];
        for ($i = 0; $i<5; $i++){
            $statusReports[] = new StatusReport($i, $location_id, "desc", "10-10-2010");
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getStatusReportsByLocation')
            ->with($this->equalTo($location_id))
            ->will($this->returnValue($statusReports));
        $statusReportRepository = new PDOStatusReportRepository($this->mockUserDAO);
        $actualStatusReports = $statusReportRepository->getStatusReportsByLocation($location_id);
        $this->assertEquals($statusReports, $actualStatusReports);
    }

    public function testAddStatusReport_StatusReportObject_CallsDao()
    {
        $statusReport = new StatusReport(1, 1, "desc", "10-10-2010");
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('addStatusReport')
            ->with($this->equalTo($statusReport));
        $statusReportRepository = new PDOStatusReportRepository($this->mockUserDAO);
        $statusReportRepository->addStatusReport($statusReport);
    }
}
