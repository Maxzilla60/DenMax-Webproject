<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:54
 */

namespace Mini\View;
use Mini\Model\Role;


class RoleJsonView
{
    public function ShowAll(array $allRoles)
    {
        header('Content-Type: application/json');
        echo '[';
        for ($index = 0; $index < sizeof($allRoles); $index++) {
            $role = $allRoles[$index];
            echo json_encode(['id' => $role->getId(),
                'rolename' => $role->getRolename()]);
            if ($index != sizeof($allRoles) - 1) {
                echo ',';
            }
        }
        echo ']';
    }


    public function ShowRole(Role $role){
        header('Content-Type: application/json');
        echo json_encode(['id' => $role->getId(),
            'rolename' => $role->getRolename()]);
    }
}