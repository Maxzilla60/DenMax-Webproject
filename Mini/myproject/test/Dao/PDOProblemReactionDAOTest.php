<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 29.10.17
 * Time: 15:34
 */

use Mini\Dao\PDOProblemReactionDAO;
use PHPUnit\Framework\TestCase;
use Mini\Model\ProblemReaction;

class PDOProblemReactionDAOTest extends TestCase
{
    public function setUp(){
        $this->connection = new PDO('sqlite::memory');
        $this->connection->exec(
            'CREATE TABLE problemreactions (
            id INTEGER PRIMARY KEY,
            problem_id int(11),
            rating tinyint(1),
            description varchar(45)
            )'
        );
    }

    public function tearDown()
    {
        $this->connection->exec('DROP TABLE problemreactions');
        $this->connection=null;
    }

    public function testGetAll_insertFive_FiveProblemReactionObjects(){
        $description = "testname";
        for ($i = 1; $i <= 5; $i++){
            $this->connection->exec("INSERT INTO problemreactions (id, problem_id, rating, description) 
                                     VALUES (NULL, '$i' ,1, '$description' );");
        }
        $problemReactionDAO = new PDOProblemReactionDAO($this->connection);
        $actualProblemReactionCount = count($problemReactionDAO->getAllProblemReactions());
        $this->assertEquals(5, $actualProblemReactionCount);
    }

    public function testGetByCompany_idExists_LocationObject(){
        $id = 1;
        $problem_id = 1;
        $rating = 0;
        $description = "testdesc";
        $problemReaction = new ProblemReaction($id, $problem_id,  $rating, $description);
        $this->connection->exec("INSERT INTO problemreactions (id, problem_id, rating, description) 
                                     VALUES (NULL, '$problem_id' , '$rating', '$description' );");
        $locationDAO = new PDOProblemReactionDAO($this->connection);
        $actualProblemReaction = $locationDAO->getProblemReactionsByProblemId($problem_id)[0];
        $this->assertEquals($problemReaction, $actualProblemReaction);
    }

    public function testAddProblemReaction_ProblemReaction_ProblemReactionObject(){
        $id = 1;
        $problem_id = 1;
        $rating = 0;
        $description = "testdesc";
        $problemReaction = new ProblemReaction($id, $problem_id,  $rating, $description);
        $locationDAO = new PDOProblemReactionDAO($this->connection);
        $locationDAO->addProblemReaction($problemReaction);

        $sql = "SELECT * FROM problemreactions";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $pr = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualProblemReaction = new ProblemReaction($pr['id'], $pr['problem_id'], $pr['rating'], $pr['description']);

        $this->assertEquals($problemReaction, $actualProblemReaction);
    }

    public function testConstructor_NoConnectionWithDefine_CreatesOwn(){
        define('DB_TYPE', 'sqlite::memory');
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DB_CHARSET', '');
        $locationDAO = new PDOProblemReactionDAO();
        $db = $locationDAO->db;
        $this->assertNotNull($db);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetAll_tableLocationsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problemreactions");
        $locationDAO = new PDOProblemReactionDAO($this->connection);
        $actualLocation = $locationDAO->getAllProblemReactions();
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetById_tableLocationsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problemreactions");
        $locationDAO = new PDOProblemReactionDAO($this->connection);
        $actualLocation = $locationDAO->getProblemReactionsByProblemId(1);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testAddProblemReaction_tableLocationsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE problemreactions");
        $locationDAO = new PDOProblemReactionDAO($this->connection);
        $actualLocation = $locationDAO->addProblemReaction(new ProblemReaction(1,1,1, "test"));
    }
}
