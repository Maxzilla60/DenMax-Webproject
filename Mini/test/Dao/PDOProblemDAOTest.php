<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 29.10.17
 * Time: 09:44
 */

use Mini\Dao\PDOProblemDAO;
use Mini\Model\Problem;
use PHPUnit\Framework\TestCase;

class PDOProblemDAOTest extends TestCase
{
    public function setUp(){
        $this->connection = new PDO('sqlite::memory');
        $this->connection->exec(
            'CREATE TABLE problems (
            id INTEGER PRIMARY KEY,
            location_id int(11),
            description varchar(130),
            date datetime,
            fixed tinyint(1),
            technician int(11)
            )'
        );
    }

    public function tearDown()
    {
        $this->connection->exec('DROP TABLE problems');
        $this->connection=null;
    }

    public function testGetAll_insertFive_FiveProblemObjects(){
        $description = "testdescription";
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        for ($i = 1; $i <= 5; $i++){
            $this->connection->exec(
                "INSERT INTO problems 
                (id, location_id, description, date, fixed, technician) VALUES 
                ('$i','$i', '$description' , '$dateString', 1, '$i');");
        }
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualLocationCount = count($problemDAO->getAllProblems());
        $this->assertEquals(5, $actualLocationCount);
    }

    public function testGetByLocation_idExists_ProblemObject(){
        $id = 1;
        $location_id = 1;
        $description = "testdescription";
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $fixed = 1;
        $technician = 1;
        $problem = new Problem($id, $location_id, $description, $dateString, $fixed, $technician);
        $this->connection->exec("INSERT INTO problems 
                (id, location_id, description, date, fixed, technician) VALUES 
                ('$id','$location_id', '$description' , '$dateString', '$fixed', '$technician');");
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualProblem = $problemDAO->getProblemsByLocation($location_id)[0];
        $this->assertEquals($problem, $actualProblem);
    }

    public function testGetByTechnician_idExists_ProblemObject(){
        $id = 1;
        $location_id = 1;
        $description = "testdescription";
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $fixed = 1;
        $technician = 1;
        $problem = new Problem($id, $location_id, $description, $dateString, $fixed, $technician);
        $this->connection->exec("INSERT INTO problems 
                (id, location_id, description, date, fixed, technician) VALUES 
                ('$id','$location_id', '$description' , '$dateString', '$fixed', '$technician');");
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualProblem = $problemDAO->getProblemsByTechnician($technician)[0];
        $this->assertEquals($problem, $actualProblem);
    }

    public function testAddProblem_Problem_ProblemObject(){
        $id = 1;
        $location_id = 1;
        $description = "testdescription";
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $fixed = 1;
        $technician = 1;
        $problem = new Problem($id, $location_id, $description, $dateString, $fixed, $technician);
        $problemDAO = new PDOProblemDAO($this->connection);
        $problemDAO->addProblem($problem);

        $sql = "SELECT * FROM problems";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $p = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualProblem = new Problem($p['id'], $p['location_id'], $p['description'], $p['date'], $p['fixed'], $p['technician']);

        $this->assertEquals($problem, $actualProblem);
    }

    public function testUpdateTechnician_ProblemExists_EditedTechnician(){
        $id = 1;
        $location_id = 1;
        $description = "testdescription";
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $fixed = 1;
        $technician = 1;
        $newTechnicianId = 9001;

        // Insert a problem in the database
        $this->connection->exec("INSERT INTO problems 
                (id, location_id, description, date, fixed, technician) VALUES 
                ('$id','$location_id', '$description' , '$dateString', '$fixed', '$technician');");

        // init DAO and update the technician
        $problemDAO = new PDOProblemDAO($this->connection);
        $problemDAO->updateTechnician($id,$newTechnicianId);

        // get technician back from database
        $sql = "SELECT * FROM problems";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $p = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualTechnicianId = $p['technician'];

        $this->assertEquals($newTechnicianId, $actualTechnicianId);
    }

    public function testDeleteTechnician_ProblemExists_NoTechnician()
    {
        $id = 1;
        $location_id = 1;
        $description = "testdescription";
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $fixed = 1;
        $technician = 1;

        // Insert a problem in the database
        $this->connection->exec("INSERT INTO problems 
                (id, location_id, description, date, fixed, technician) VALUES 
                ('$id','$location_id', '$description' , '$dateString', '$fixed', '$technician');");

        // init DAO and update the technician
        $problemDAO = new PDOProblemDAO($this->connection);
        $problemDAO->deleteTechnician($id);

        // get technician back from database
        $sql = "SELECT * FROM problems";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $p = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualTechnicianId = $p['technician'];

        $this->assertNull($actualTechnicianId);
    }

    public function testFixProblem_ProblemExists_ProblemIsFixed()
    {
        $id = 1;
        $location_id = 1;
        $description = "testdescription";
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $fixed = 0; // Problem needs fixing
        $technician = 1;

        // Insert a problem in the database
        $this->connection->exec("INSERT INTO problems 
                (id, location_id, description, date, fixed, technician) VALUES 
                ('$id','$location_id', '$description' , '$dateString', '$fixed', '$technician');");

        // init DAO and update the technician
        $problemDAO = new PDOProblemDAO($this->connection);
        $problemDAO->fixProblem($id);

        // get technician back from database
        $sql = "SELECT * FROM problems";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $p = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualFixed = $p['fixed'];

        $this->assertEquals(1, $actualFixed);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetAll_tableProblemsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problems");
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualProblem = $problemDAO->getAllProblems();
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetByLocation_tableProblemsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problems");
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualProblem = $problemDAO->getProblemsByLocation(1);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetByTechnician_tableProblemsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problems");
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualProblem = $problemDAO->getProblemsByTechnician(1);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testAddProblem_tableProblemsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problems");
        $problemDAO = new PDOProblemDAO($this->connection);
        $date = new DateTime();
        $dateString = $date->format("YYYY-MM-DD");
        $actualProblem = $problemDAO->addProblem(
            new Problem(1,1,"", $dateString, 1,1));
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testUpdateTechnician_tableProblemsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problems");
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualProblem = $problemDAO->updateTechnician(1, 1);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testDeleteTechnician_tableProblemsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problems");
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualProblem = $problemDAO->deleteTechnician(1);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testFixProblem_tableProblemsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problems");
        $problemDAO = new PDOProblemDAO($this->connection);
        $actualProblem = $problemDAO->fixProblem(1);
    }


    public function testConstructor_NoConnectionWithDefine_CreatesOwn(){
        define('DB_TYPE', 'sqlite::memory');
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DB_CHARSET', '');
        $problemDAO = new PDOProblemDAO();
        $db = $problemDAO->db;
        $this->assertNotNull($db);
    }
}


