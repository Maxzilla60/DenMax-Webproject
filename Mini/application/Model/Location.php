<?php

namespace Mini\Model;

class Location
{
    private $id;
    private $name;
    private $company_id;

    public function __construct($id, $name, $company_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->company_id = $company_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCompanyId()
    {
        return $this->company_id;
    }

    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }
}
