<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 29.10.17
 * Time: 20:17
 */

use Mini\Dao\PDOStatusReportDAO;
use Mini\Model\StatusReport;
use PHPUnit\Framework\TestCase;

class PDOStatusReportDAOTest extends TestCase
{
    public function setUp(){
        $this->connection = new PDO('sqlite::memory');
        $this->connection->exec(
            'CREATE TABLE statusreports (
            id INTEGER PRIMARY KEY,
            status int(11),
            date datetime,
            location_id int(11)
            )'
        );
    }

    public function tearDown()
    {
        $this->connection->exec('DROP TABLE statusreports');
        $this->connection=null;
    }

    public function testGetAll_insertFive_FiveLocationObjects(){
        $status = 3;
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $location = 1;
        for ($i = 1; $i <= 5; $i++){
            $this->connection->exec("INSERT INTO statusreports (id, status, date, location_id) 
                                     VALUES (NULL,'$status', '$dateString', '$location');");
        }
        $statusReportDAO = new PDOStatusReportDAO($this->connection);
        $actualStatusReportCount = count($statusReportDAO->getAllStatusReports());
        $this->assertEquals(5, $actualStatusReportCount);
    }

    public function testGetById_idExists_StatusReportObject(){
        $id = 1;
        $status = 3;
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $location = 1;
        $statusReport = new StatusReport($id, $location, $status, $dateString);
        $this->connection->exec("INSERT INTO statusreports (id, status, date, location_id) 
                                 VALUES (NULL,'$status', '$dateString', '$location');");
        $statusReportDAO = new PDOStatusReportDAO($this->connection);
        $actualStatusReport = $statusReportDAO->getStatusReportsById($id)[0];
        $this->assertEquals($statusReport, $actualStatusReport);
    }

    public function testGetByLocation_idExists_StatusReportObject(){
        $status = 3;
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $location = 1;
        $statusReport = new StatusReport(1, $location, $status, $dateString);
        $this->connection->exec("INSERT INTO statusreports (id, status, date, location_id) 
                                 VALUES (NULL,'$status', '$dateString', '$location');");
        $statusReportDAO = new PDOStatusReportDAO($this->connection);
        $actualStatusReport = $statusReportDAO->getStatusReportsByLocation($location)[0];
        $this->assertEquals($statusReport, $actualStatusReport);
    }

    public function testAddLocation_Location_LocationObject(){
        $status = 3;
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $location = 1;
        $statusReport = new StatusReport(1, $location, $status, $dateString);
        $locationDAO = new PDOStatusReportDAO($this->connection);
        $locationDAO->addStatusReport($statusReport);

        $sql = "SELECT * FROM statusreports";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $sr = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualStatusReport = new StatusReport($sr['id'], $sr['location_id'], $sr['status'], $sr['date']);

        $this->assertEquals($statusReport, $actualStatusReport);
    }

    public function testConstructor_NoConnectionWithDefine_CreatesOwn(){
        define('DB_TYPE', 'sqlite::memory');
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DB_CHARSET', '');
        $locationDAO = new PDOStatusReportDAO();
        $db = $locationDAO->db;
        $this->assertNotNull($db);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetAll_tableStatusReportsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE statusreports");
        $locationDAO = new PDOStatusReportDAO($this->connection);
        $actualLocation = $locationDAO->getAllStatusReports(0);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetById_tableStatusReportsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE statusreports");
        $locationDAO = new PDOStatusReportDAO($this->connection);
        $actualLocation = $locationDAO->getStatusReportsById(0);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetByLocation_tableStatusReportsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE statusreports");
        $locationDAO = new PDOStatusReportDAO($this->connection);
        $actualLocation = $locationDAO->getStatusReportsByLocation(0);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testAddStatusReport_tableStatusReportsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE statusreports");
        $locationDAO = new PDOStatusReportDAO($this->connection);
        $actualLocation = $locationDAO->addStatusReport(new StatusReport(1,1,1,null));
    }
}
