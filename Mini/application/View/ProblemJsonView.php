<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:37
 */

namespace Mini\View;
use Mini\Model\Problem;


class ProblemJsonView
{
    public function ShowAll(array $allProblems)
    {
        header('Content-Type: application/json');
        echo '[';
        for ($index = 0; $index < sizeof($allProblems); $index++) {
            $problem = $allProblems[$index];
            echo json_encode(['id' => $problem->getId(),
                'location_id' => $problem->getLocationId(),
                'description' => $problem->getDescription(),
                'date' => $problem->getDate(),
                'fixed' => $problem->getFixed(),
                'technician' => $problem->getTechnician()]);
            if ($index != sizeof($allProblems) - 1) {
                echo ',';
            }
        }
        echo ']';
    }


    public function ShowProblem(Problem $problem){
        header('Content-Type: application/json');
        echo json_encode(['id' => $problem->getId(),
            'location_id' => $problem->getLocationId(),
            'description' => $problem->getDescription(),
            'date' => $problem->getDate(),
            'fixed' => $problem->getFixed(),
            'technician' => $problem->getTechnician()]);
    }
}