<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:47
 */

namespace Mini\View;
use Mini\Model\User;


class UserJsonView
{
    public function ShowAll(array $allUsers)
    {
        header('Content-Type: application/json');
        echo '[';
        for ($index = 0; $index < sizeof($allUsers); $index++) {
            $user = $allUsers[$index];
            echo json_encode(['id' => $user->getId(),
                'name' => $user->getName(),
                'role' => $user->getRole()]);
            if ($index != sizeof($allUsers) - 1) {
                echo ',';
            }
        }
        echo ']';
    }


    public function ShowUser(User $user){
        header('Content-Type: application/json');
        echo json_encode(['id' => $user->getId(),
            'name' => $user->getName(),
            'role' => $user->getRole()]);
    }
}