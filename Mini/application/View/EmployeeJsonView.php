<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:19
 */

namespace Mini\View;
use Mini\Model\Employee;


class EmployeeJsonView
{
    public function ShowAll(array $allEmployees)
    {
        header('Content-Type: application/json');
        echo '[';
        for ($index = 0; $index < sizeof($allEmployees); $index++) {
            $employee = $allEmployees[$index];
            echo json_encode(['company_id' => $employee->getCompanyId(),
                'user_id' => $employee->getUserId()]);
            if ($index != sizeof($allEmployees) - 1) {
                echo ',';
            }
        }
        echo ']';
    }


    public function ShowEmployee(Employee $employee){
        header('Content-Type: application/json');
        echo json_encode(['company_id' => $employee->getCompanyId(),
            'user_id' => $employee->getUserId()]);
    }
}