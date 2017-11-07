<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 10:50
 */

use Mini\Repository\PDOUserRepository;
use PHPUnit\Framework\TestCase;
use Mini\Model\User;

class PDOUserRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->mockUserDAO = $this->getMockBuilder('Mini\Dao\PDOUserDAO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->mockUserDAO = null;
    }

    public function testGetAll_UserArray()
    {
        $users = [];
        for ($i = 0; $i<5; $i++){
            $users[] = new User($i, "name", 1);
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getAllUsers')
            ->will($this->returnValue($users));
        $statusReportRepository = new PDOUserRepository($this->mockUserDAO);
        $actualStatusReports = $statusReportRepository->getAllUsers();
        $this->assertEquals($users, $actualStatusReports);
    }

    public function testGetById_UserArray()
    {
        $id = "1";
        $user = new User($id, "name", 1);
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getUsersById')
            ->with($this->equalTo($id))
            ->will($this->returnValue($user));
        $statusReportRepository = new PDOUserRepository($this->mockUserDAO);
        $actualStatusReports = $statusReportRepository->getUsersById($id);
        $this->assertEquals($user, $actualStatusReports);
    }

    public function testGetByRole_UserArray()
    {
        $role = "2";
        $users = [];
        for ($i = 0; $i<5; $i++){
            $users[] = new User($i, "name", $role);
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getUsersByRole')
            ->with($this->equalTo($role))
            ->will($this->returnValue($users));
        $statusReportRepository = new PDOUserRepository($this->mockUserDAO);
        $actualStatusReports = $statusReportRepository->getUsersByRole($role);
        $this->assertEquals($users, $actualStatusReports);
    }

    public function testGetByUserName_UserArray()
    {
        $name = "testname";
        $user = new User(1, $name, 1);
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getUserByUsername')
            ->with($this->equalTo($name))
            ->will($this->returnValue($user));
        $statusReportRepository = new PDOUserRepository($this->mockUserDAO);
        $actualStatusReports = $statusReportRepository->getUserByUsername($name);
        $this->assertEquals($user, $actualStatusReports);
    }

    public function testAddUser_CallsDAO()
    {
        $user = new User(1,"name",1);
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('addUser')
            ->with($this->equalTo($user));
        $statusReportRepository = new PDOUserRepository($this->mockUserDAO);
        $actualStatusReports = $statusReportRepository->addUser($user);
    }

    public function testUpdateUser_CallsDAO()
    {
        $id = 1;
        $name = "name";
        $role = 1;
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('updateUser')
            ->with($this->equalTo($id), $this->equalTo($name), $this->equalTo($role));
        $statusReportRepository = new PDOUserRepository($this->mockUserDAO);
        $statusReportRepository->updateUser($id, $name, $role);
    }

    public function testDeleteUser_CallsDAO()
    {
        $id = 1;
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('deleteUser')
            ->with($this->equalTo($id));
        $statusReportRepository = new PDOUserRepository($this->mockUserDAO);
        $statusReportRepository->deleteUser($id);
    }
}
