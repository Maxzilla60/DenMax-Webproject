<?php

namespace Mini\Repository;

use Mini\Dao\PDOCompanyDAO;
use Mini\Model\Company;

class PDOCompanyRepository
{
    private $companyDAO;

    public function __construct(PDOCompanyDAO $companyDAO)
    {
        $this->companyDAO = $companyDAO;
    }

    public function getAllCompanies() {
        $companies = $this->companyDAO->getAllCompanies();
        return $companies;
    }


    public function getCompanyByUser($user_id) {
        $companies = null;
        if($this->isValidId($user_id)) {
            $companies = $this->companyDAO->getCompanyByUser($user_id);
        }
        return $companies;
    }

    private function isValidId($id)
    {
        if (is_string($id) && ctype_digit(trim($id))) {
            $id=(int)$id;
        }
        return is_integer($id) and $id >= 0;
    }
}
