<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 00:21
 */

use Mini\Repository\PDORoleRepository;
use PHPUnit\Framework\TestCase;
use Mini\Model\Role;

class PDORoleRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->mockUserDAO = $this->getMockBuilder('Mini\Dao\PDORoleDAO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->mockUserDAO = null;
    }

    public function testGetAll_RoleArray()
    {
        $roles = [];
        for ($i = 0; $i<5; $i++){
            $roles[] = new Role($i, "role");
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getAllRoles')
            ->will($this->returnValue($roles));
        $roleRepository = new PDORoleRepository($this->mockUserDAO);
        $actualRoles = $roleRepository->getAllRoles();
        $this->assertEquals($roles, $actualRoles);
    }
}
