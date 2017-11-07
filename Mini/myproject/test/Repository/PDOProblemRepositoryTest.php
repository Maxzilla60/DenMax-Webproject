<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 00:24
 */

use Mini\Repository\PDOProblemRepository;
use PHPUnit\Framework\TestCase;
use Mini\Model\Problem;

class PDOProblemRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->mockUserDAO = $this->getMockBuilder('Mini\Dao\PDOProblemDAO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->mockUserDAO = null;
    }

    public function testGetAll_ProblemArray()
    {
        $problems = [];
        for ($i = 0; $i<5; $i++){
            $problems[] = new Problem($i, $i, "desc", "10-10-2010", 1, $i);
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getAllProblems')
            ->will($this->returnValue($problems));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $actualProblems = $problemRepository->getAllProblems();
        $this->assertEquals($problems, $actualProblems);
    }

    public function testGetById_IdExists_ProblemArray()
    {
        $id = 1;
        $problem = new Problem($id, 1, "desc", "10-10-2010", 1, 1);
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getProblemsById')
            ->with($this->equalTo($id))
            ->will($this->returnValue($problem));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $actualProblems = $problemRepository->getProblemsById($id);
        $this->assertEquals($problem, $actualProblems);
    }

    public function testGetByLocation_IdExists_ProblemArray()
    {
        $location_id = "2";
        $problems = [];
        for ($i = 0; $i<5; $i++){
            $problems[] = new Problem($i, $location_id, "desc", "10-10-2010", 1, $i);
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getProblemsByLocation')
            ->with($this->equalTo($location_id))
            ->will($this->returnValue($problems));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $actualProblems = $problemRepository->getProblemsByLocation($location_id);
        $this->assertEquals($problems, $actualProblems);
    }

    public function testGetByTechnician_IdExists_ProblemArray()
    {
        $technician = "2";
        $problems = [];
        for ($i = 0; $i<5; $i++){
            $problems[] = new Problem($i, $i, "desc", "10-10-2010", 1, $technician);
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getProblemsByTechnician')
            ->with($this->equalTo($technician))
            ->will($this->returnValue($problems));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $actualProblems = $problemRepository->getProblemsByTechnician($technician);
        $this->assertEquals($problems, $actualProblems);
    }

    public function testGetScore_IdExists_ProblemArray()
    {
        $problem_id = "2";
        $score = 4;
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getProblemScoreFromReactions')
            ->with($this->equalTo($problem_id))
            ->will($this->returnValue($score));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $actualScore = $problemRepository->getProblemScoreFromReactions($problem_id);
        $this->assertEquals($score, $actualScore);
    }

    public function testAddProblem_ProblemObject_CallsDao()
    {
        $problem = new Problem(1, 1, "desc", "10-10-2010", 1, 1);
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('addProblem')
            ->with($this->equalTo($problem));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $problemRepository->addProblem($problem);
    }

    public function testUpdateTechnician_IdExists_CallsDao()
    {
        $id = 1;
        $technician = 2;
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('updateTechnician')
            ->with($this->equalTo($id), $this->equalTo($technician));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $problemRepository->updateTechnician($id, $technician);
    }

    public function testDeleteTechnician_IdExists_CallsDao()
    {
        $id = 1;
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('deleteTechnician')
            ->with($this->equalTo($id));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $problemRepository->deleteTechnician($id);
    }

    public function testFixProblem_IdExists_CallsDao()
    {
        $id = 1;
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('fixProblem')
            ->with($this->equalTo($id));
        $problemRepository = new PDOProblemRepository($this->mockUserDAO);
        $problemRepository->fixProblem($id);
    }
}
