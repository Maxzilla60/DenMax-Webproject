<?php

namespace Mini\Repository;

use Mini\Dao\PDOProblemDAO;
use Mini\Model\Problem;

class PDOProblemRepository
{
    private $problemDAO;

    public function __construct(PDOProblemDAO $problemDAO)
    {
        $this->problemDAO = $problemDAO;
    }

    public function getAllProblems() {
        $problems = $this->problemDAO->getAllProblems();
        return $problems;
    }

    public function getProblemsById($id){
        $problems = $this->problemDAO->getProblemsById($id);
        return $problems;
    }


    public function getProblemsByLocation($location_id) {
        $problems = null;
        if($this->isValidId($location_id)) {
            $problems = $this->problemDAO->getProblemsByLocation($location_id);
        }
        return $problems;
    }

    public function getProblemsByTechnician($technician_id) {
        $problems = null;
        if($this->isValidId($technician_id)) {
            $problems = $this->problemDAO->getProblemsByTechnician($technician_id);
        }
        return $problems;
    }

    public function addProblem(Problem $problem) {
        $this->problemDAO->addProblem($problem);
    }

    public function updateTechnician($problem_id, $technician) {
        $this->problemDAO->updateTechnician($problem_id, $technician);
    }

    public function deleteTechnician($problem_id) {
        $this->problemDAO->deleteTechnician($problem_id);
    }

    public function fixProblem($problem_id) {
        $this->problemDAO->fixProblem($problem_id);
    }

    public function getProblemScoreFromReactions($problem_id){
        $problems = null;
        if($this->isValidId($problem_id)) {
            $problems = $this->problemDAO->getProblemScoreFromReactions($problem_id);
        }
        return $problems;
    }

    private function isValidId($id)
    {
        if (is_string($id) && ctype_digit(trim($id))) {
            $id=(int)$id;
        }
        return is_integer($id) and $id >= 0;
    }
}
