<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:14
 */

namespace Mini\View;
use Mini\Model\Company;


class CompanyJsonView
{
    public function ShowAll(array $allCompanies)
    {
        header('Content-Type: application/json');
        echo '[';
        for ($index = 0; $index < sizeof($allCompanies); $index++) {
            $company = $allCompanies[$index];
            echo json_encode(['id' => $company->getId(),
                'name' => $company->getName()]);
            if ($index != sizeof($allCompanies) - 1) {
                echo ',';
            }
        }
        echo ']';
    }


    public function ShowCompany(Company $company){
        header('Content-Type: application/json');
        echo json_encode(['id' => $company->getId(),
            'name' => $company->getName()]);
    }
}