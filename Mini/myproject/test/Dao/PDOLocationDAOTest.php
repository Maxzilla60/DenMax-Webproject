<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 28.10.17
 * Time: 21:48
 */

use Mini\Dao\PDOLocationDAO;
use Mini\Model\Location;
use PHPUnit\Framework\TestCase;

class PDOLocationDAOTest extends TestCase
{
    public function setUp(){
        $this->connection = new PDO('sqlite::memory');
        $this->connection->exec(
            'CREATE TABLE locations (
            id INTEGER PRIMARY KEY,
            name varchar(50),
            company_id int(11)
            )'
        );
    }

    public function tearDown()
    {
        $this->connection->exec('DROP TABLE locations');
        $this->connection=null;
    }

    public function testGetAll_insertFive_FiveLocationObjects(){
        $name = "testname";
        for ($i = 1; $i <= 5; $i++){
            $this->connection->exec("INSERT INTO locations (id, name, company_id) VALUES (NULL,'$name', NULL );");
        }
        $locationDAO = new PDOLocationDAO($this->connection);
        $actualLocationCount = count($locationDAO->getAllLocations());
        $this->assertEquals(5, $actualLocationCount);
    }

    public function testGetByCompany_idExists_LocationObject(){
        $id = 1;
        $name = "testname";
        $company_id = 1;
        $location = new Location($id, $name, $company_id);
        $this->connection->exec("INSERT INTO locations (id, name, company_id) VALUES (NULL,'$name', 1);");
        $locationDAO = new PDOLocationDAO($this->connection);
        $actualLocation = $locationDAO->getLocationsByCompany($company_id)[0];
        $this->assertEquals($location, $actualLocation);
    }

    public function testAddLocation_Location_LocationObject(){
        $id = 1;
        $name = "testname";
        $company_id = 1;
        $location = new Location($id, $name, $company_id);
        $locationDAO = new PDOLocationDAO($this->connection);
        $locationDAO->addLocation($location);

        $sql = "SELECT * FROM locations";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $l = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualLocation = new Location($l['id'], $l['name'], $l['company_id']);

        $this->assertEquals($location, $actualLocation);
    }

    public function testGetByCompany_idDoesNotExist_Null()
    {
        $id=1;
        $locationDAO = new PDOLocationDAO($this->connection);
        $actualLocationCount = count($locationDAO->getLocationsByCompany($id));
        $this->assertEquals(0, $actualLocationCount);
    }

    public function testConstructor_NoConnectionWithDefine_CreatesOwn(){
        define('DB_TYPE', 'sqlite::memory');
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DB_CHARSET', '');
        $locationDAO = new PDOLocationDAO();
        $db = $locationDAO->db;
        $this->assertNotNull($db);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetByCompany_tableLocationsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE locations");
        $locationDAO = new PDOLocationDAO($this->connection);
        $actualLocation = $locationDAO->getLocationsByCompany(0);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetAll_tableLocationsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE locations");
        $locationDAO = new PDOLocationDAO($this->connection);
        $actualLocation = $locationDAO->getAllLocations();
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testAdd_tableLocationsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE locations");
        $locationDAO = new PDOLocationDAO($this->connection);
        $actualLocation = $locationDAO->addLocation(new Location(1,"testname", 1));
    }
}
