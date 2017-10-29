<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 29.10.17
 * Time: 15:20
 */

use Mini\Dao\PDORoleDAO;
use Mini\Model\Role;
use PHPUnit\Framework\TestCase;

class PDORoleDAOTest extends TestCase
{
    public function setUp(){
        $this->connection = new PDO('sqlite::memory');
        $this->connection->exec(
            'CREATE TABLE roles (
            id INTEGER PRIMARY KEY,
            rolename varchar(45)
            )'
        );
    }

    public function tearDown()
    {
        $this->connection->exec('DROP TABLE roles');
        $this->connection=null;
    }

    public function testGetAll_insertFive_FiveRoleObjects(){
        $name = "testname";
        for ($i = 1; $i <= 5; $i++){
            $this->connection->exec("INSERT INTO roles (id, rolename) VALUES (NULL,'$name .. $i');");
        }
        $roleDAO = new PDORoleDAO($this->connection);
        $actualRoleCount = count($roleDAO->getAllRoles());
        $this->assertEquals(5, $actualRoleCount);
    }

    public function testConstructor_NoConnectionWithDefine_CreatesOwn(){
        define('DB_TYPE', 'sqlite::memory');
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DB_CHARSET', '');
        $locationDAO = new PDORoleDAO();
        $db = $locationDAO->db;
        $this->assertNotNull($db);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetAll_tableLocationsDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE roles");
        $locationDAO = new PDORoleDAO($this->connection);
        $actualLocation = $locationDAO->getAllRoles();
    }
}
