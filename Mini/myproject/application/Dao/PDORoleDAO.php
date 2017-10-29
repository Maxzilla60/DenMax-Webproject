<?php

/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 27.10.17
 * Time: 09:38
 */
namespace Mini\Dao;

use Mini\Core\Model;
use Mini\Model\Role;

class PDORoleDAO extends Model
{

    function __construct(\PDO $connection = null)
    {
        if($connection != null){
            $this->db = $connection;
        } else {
            parent::__construct();
        }
    }

    public function getAllRoles() {
        try {
            $sql = "SELECT * FROM roles";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $query->execute();
            $fetchedRoles = $query->fetchAll(\PDO::FETCH_ASSOC);

            $roleArray = array();
            if (count($fetchedRoles) > 0) {
                foreach ($fetchedRoles as $l) {
                    $roleArray[] = new Role($l['id'], $l['rolename']);
                }
            }

            return $roleArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }
}