<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 10:05
 */

use Mini\Dao\PDOCompanyDAO;
use PHPUnit\Framework\TestCase;
use Mini\Model\Company;

class PDOCompanyDAOTest extends TestCase
{
    public function setUp(){
        $this->connection = new PDO('sqlite::memory');
        $this->connection->exec(
            'CREATE TABLE companies (
            id INTEGER PRIMARY KEY,
            name varchar(100)
            )'
        );
        $this->connection->exec(
            'CREATE TABLE employees (
            user_id INTEGER PRIMARY KEY,
            company_id int
            )'
        );
    }

    public function tearDown()
    {
        $this->connection->exec('DROP TABLE companies');
        $this->connection=null;
    }

    public function testGetAll_insertFive_FiveCompanyObjects(){
        $name = "testname";
        for ($i = 1; $i <= 5; $i++){
            $this->connection->exec("INSERT INTO companies (id, name) VALUES (NULL,'$name');");
        }
        $companyDAO = new PDOCompanyDAO($this->connection);
        $actualCompanyCount = count($companyDAO->getAllCompanies());
        $this->assertEquals(5, $actualCompanyCount);
    }

    public function testGetByUser_idExists_CompanyObject(){
        $id = 1;
        $user_id = 1;
        $name = "testname";
        $location = new Company($id, $name);
        $this->connection->exec("INSERT INTO companies (id, name) VALUES (NULL,'$name');");
        $this->connection->exec("INSERT INTO employees (user_id, company_id) VALUES (NULL,'$id');");
        $companyDAO = new PDOCompanyDAO($this->connection);
        $actualCompany = $companyDAO->getCompanyByUser($user_id)[0];
        $this->assertEquals($location, $actualCompany);
    }

    public function testConstructor_NoConnectionWithDefine_CreatesOwn(){
        define('DB_TYPE', 'sqlite::memory');
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DB_CHARSET', '');
        $locationDAO = new PDOCompanyDAO();
        $db = $locationDAO->db;
        $this->assertNotNull($db);
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetAll_tableCompaniesDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE companies");
        $companyDAO = new PDOCompanyDAO($this->connection);
        $actualCompany = $companyDAO->getAllCompanies();
    }

    /**
     * @expectedException Mini\Dao\DaoException
     **/
    public function testGetByUser_tableCompaniesDoesntExist_ModelException()
    {
        $this->connection->exec("DROP TABLE companies");
        $companyDAO = new PDOCompanyDAO($this->connection);
        $actualCompany = $companyDAO->getCompanyByUser(1);
    }
}
