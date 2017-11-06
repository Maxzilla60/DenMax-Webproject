<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 06.11.17
 * Time: 14:10
 */

use Mini\Dao\PDOUserDAO;
use PHPUnit\Framework\TestCase;
use Mini\Model\User;

class PDOUserDAOTest extends TestCase
{
    public function setUp(){
        $this->connection = new PDO('sqlite::memory');
        $this->connection->exec(
            'CREATE TABLE users (
            id INTEGER PRIMARY KEY,
            name varchar(50),
            role int(11)
            )'
        );
    }

    public function tearDown()
    {
        $this->connection->exec('DROP TABLE users');
        $this->connection=null;
    }

    public function testGetAll_insertFive_FiveUserObjects(){
        $name = "testname";
        for ($i = 1; $i <= 5; $i++){
            $this->connection->exec("INSERT INTO users (id, name, role) VALUES (NULL,'$name', 0 );");
        }
        $locationDAO = new PDOUserDAO($this->connection);
        $actualUserCount = count($locationDAO->getAllUsers());
        $this->assertEquals(5, $actualUserCount);
    }

    public function testGetByRole_idExists_RoleObject(){
        $id = 1;
        $name = "testname";
        $role = 1;
        $location = new User($id, $name, $role);
        $this->connection->exec("INSERT INTO users (id, name, role) VALUES (NULL,'$name', '$role');");
        $locationDAO = new PDOUserDAO($this->connection);
        $actualLocation = $locationDAO->getUsersByRole($role)[0];
        $this->assertEquals($location, $actualLocation);
    }

    public function testConstructor_NoConnectionWithDefine_CreatesOwn(){
        define('DB_TYPE', 'sqlite::memory');
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DB_CHARSET', '');
        $locationDAO = new PDOUserDAO();
        $db = $locationDAO->db;
        $this->assertNotNull($db);
    }

    public function testAddUser_User_UserObject(){
        $id = 1;
        $name = "testname";
        $role = 1;
        $user = new User($id, $name, $role);
        $locationDAO = new PDOUserDAO($this->connection);
        $locationDAO->addUser($user);

        $sql = "SELECT * FROM users";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $l = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualUser = new User($l['id'], $l['name'], $l['role']);

        $this->assertEquals($user, $actualUser);
    }

    public function testUpdateUser_UserExists_UpdatedUser()
    {
        $id = 1;
        $name = "testname";
        $newName = 'newname';
        $role = 1;
        $newRole = 2;

        // Insert a problem in the database
        $this->connection->exec("INSERT INTO users 
                (id, name, role) VALUES 
                (NULL , '$name', '$role');");

        // init DAO and delete the user
        $userDAO = new PDOUserDAO($this->connection);
        $userDAO->updateUser($id, $newName, $newRole);

        // get userCount back from database
        $sql = "SELECT * FROM users";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $u = $query->fetchAll(\PDO::FETCH_ASSOC)[0];
        $actualUserName = $u['name'];
        $actualUserRole = $u['role'];

        $this->assertEquals($newName, $actualUserName);
        $this->assertEquals($newRole, $actualUserRole);

    }

    public function testDeleteUser_UserExists_NoUser()
    {
        $id = 1;
        $name = "testname";
        $role = 1;

        // Insert a problem in the database
        $this->connection->exec("INSERT INTO users 
                (id, name, role) VALUES 
                (NULL , '$name', '$role');");

        // init DAO and delete the user
        $userDAO = new PDOUserDAO($this->connection);
        $userDAO->deleteUser($id);

        // get userCount back from database
        $sql = "SELECT * FROM users";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $userCount = count($query->fetchAll(\PDO::FETCH_ASSOC));

        $this->assertEquals(0, $userCount);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetAll_tableUsersDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE users");
        $userDAO = new PDOUserDAO($this->connection);
        $actualusers = $userDAO->getAllUsers();
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetByRole_tableUsersDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE users");
        $userDAO = new PDOUserDAO($this->connection);
        $actualusers = $userDAO->getUsersByRole(0);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testAdd_tableUsersDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE users");
        $userDAO = new PDOUserDAO($this->connection);
        $userDAO->addUser(new User(0,0,0));
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testUpdate_tableUsersDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE users");
        $userDAO = new PDOUserDAO($this->connection);
        $userDAO->updateUser(0,0,0);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testDelete_tableUsersDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE users");
        $userDAO = new PDOUserDAO($this->connection);
        $userDAO->deleteUser(0);
    }
}
