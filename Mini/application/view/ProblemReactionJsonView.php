<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:43
 */

namespace Mini\View;
use Mini\Model\ProblemReaction;


class ProblemReactionJsonView
{
    public function ShowAll(array $allProblemsReactions)
    {
        header('Content-Type: application/json');
        echo '[';
        for ($index = 0; $index < sizeof($allProblemsReactions); $index++) {
            $problemReaction = $allProblemsReactions[$index];
            echo json_encode(['id' => $problemReaction->getId(),
                'problem_id' => $problemReaction->getProblemId(),
                'rating' => $problemReaction->getRating(),
                'description' => $problemReaction->getDescription()]);
            if ($index != sizeof($allProblemsReactions) - 1) {
                echo ',';
            }
        }
        echo ']';
    }


    public function ShowProblemReaction(ProblemReaction $problemReaction){
        header('Content-Type: application/json');
        echo json_encode(['id' => $problemReaction->getId(),
            'problem_id' => $problemReaction->getProblemId(),
            'rating' => $problemReaction->getRating(),
            'description' => $problemReaction->getDescription()]);
    }
}