<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 06.11.17
 * Time: 15:13
 */

use Mini\Repository\PDOProblemReactionRepository;
use PHPUnit\Framework\TestCase;
use Mini\Model\ProblemReaction;

class PDOProblemReactionRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->mockUserDAO = $this->getMockBuilder('Mini\Dao\PDOProblemReactionDAO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->mockUserDAO = null;
    }

    public function testFindProblemReactionsByProblemId_idExists_ProblemReactionObject()
    {
        $problem_id = "2";
        $problemReactions = [];
        for ($i = 0; $i<5; $i++){
            $problemReactions[] = new ProblemReaction($i, $problem_id, 1, "description");
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getProblemReactionsByProblemId')
            ->with($this->equalTo($problem_id))
            ->will($this->returnValue($problemReactions));
        $problemReactionRepository = new PDOProblemReactionRepository($this->mockUserDAO);
        $actualReactions = $problemReactionRepository->getProblemReactionsByProblemId($problem_id);
        $this->assertEquals($problemReactions, $actualReactions);
    }

    public function testAddProblemReaction_ProblemReactionObject_CallsDao()
    {
        $problemReaction = new ProblemReaction(1, 1, 1, "desc");
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('addProblemReaction')
            ->with($this->equalTo($problemReaction));
        $problemReactionRepository = new PDOProblemReactionRepository($this->mockUserDAO);
        $problemReactionRepository->addProblemReaction($problemReaction);
    }

    public function testGetAll_ProblemReactionArray()
    {
        $problemReactions = [];
        for ($i = 0; $i<5; $i++){
            $problemReactions[] = new ProblemReaction($i, $i, 1, "description");
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getAllProblemReactions')
            ->will($this->returnValue($problemReactions));
        $problemReactionRepository = new PDOProblemReactionRepository($this->mockUserDAO);
        $actualProblemReactions = $problemReactionRepository->getAllProblemReactions();
        $this->assertEquals($problemReactions, $actualProblemReactions);
    }
}
