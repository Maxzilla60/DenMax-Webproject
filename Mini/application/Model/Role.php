<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 12:00
 */

namespace Mini\Model;


class Role
{
    private $id;
    private $rolename;

    /**
     * Role constructor.
     * @param $id
     * @param $rolename
     */
    public function __construct($id, $rolename)
    {
        $this->id = $id;
        $this->rolename = $rolename;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRolename()
    {
        return $this->rolename;
    }

    /**
     * @param mixed $rolename
     */
    public function setRolename($rolename)
    {
        $this->rolename = $rolename;
    }


}