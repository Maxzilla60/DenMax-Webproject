<?php

namespace Mini\Model;

class Employee
{
    private $company_id;
    private $user_id;

    public function __construct($company_id, $user_id)
    {
        $this->company_id = $company_id;
        $this->user_id = $user_id;
    }

    public function getCompanyId()
    {
        return $this->company_id;
    }

    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
}