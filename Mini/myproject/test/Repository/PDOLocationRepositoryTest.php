<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 06.11.17
 * Time: 14:48
 */

use Mini\Repository\PDOLocationRepository;
use PHPUnit\Framework\TestCase;
use Mini\Model\Location;

class PDOLocationRepositoryTest extends TestCase
{

    public function setUp()
    {
        $this->mockUserDAO = $this->getMockBuilder('Mini\Dao\PDOLocationDAO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->mockUserDAO = null;
    }

    public function testFindLocationByCompany_idExists_LocationObject()
    {
        $id = "1";
        $name= 'testname';
        $company_id = 1;
        $location = new Location($id, $name, $company_id);
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getLocationsByCompany')
            ->with($this->equalTo($id))
            ->will($this->returnValue($location));
        $locationRepository = new PDOLocationRepository($this->mockUserDAO);
        $actualLocation = $locationRepository->getLocationsByCompany($id);
        $this->assertEquals($location, $actualLocation);
    }

    public function testAddLocation_LocationObject_CallsDao()
    {
        $id = "1";
        $name= 'testname';
        $company_id = 1;
        $location = new Location($id, $name, $company_id);
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('addLocation')
            ->with($this->equalTo($location));
        $locationRepository = new PDOLocationRepository($this->mockUserDAO);
        $locationRepository->addLocation($location);
    }

    public function testgetAll_LocationArray()
    {
        $locations = [];
        for ($i = 0; $i<5; $i++){
            $locations[] = new Location($i, "name", $i);
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getAllLocations')
            ->will($this->returnValue($locations));
        $locationRepository = new PDOLocationRepository($this->mockUserDAO);
        $actualLocations = $locationRepository->getAllLocations();
        $this->assertEquals($locations, $actualLocations);
    }
}
