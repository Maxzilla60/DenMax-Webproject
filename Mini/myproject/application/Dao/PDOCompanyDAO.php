<?php

/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 27.10.17
 * Time: 09:22
 */

namespace Mini\Dao;

use Mini\Core\Model;
use Mini\Model\Company;

class PDOCompanyDAO extends Model
{
    function __construct(\PDO $connection = null)
    {
        if($connection != null){
            $this->db = $connection;
        } else {
            parent::__construct();
        }
    }

    public function getAllCompanies() {
        try {
            $sql = "SELECT * FROM companies";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $query->execute();
            $fetchedCompanies = $query->fetchAll(\PDO::FETCH_ASSOC);

            $companiesArray = array();
            if (count($fetchedCompanies) > 0) {
                foreach ($fetchedCompanies as $c) {
                    $companiesArray[] = new Company($c['id'], $c['name']);
                }
            }

            return $companiesArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }


    public function getCompanyByUser($user_id) {
        try {
            $sql = "SELECT * FROM companies WHERE id IN (SELECT company_id FROM employees WHERE user_id = :user_id)";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':user_id' => $user_id);
            $query->execute($parameters);

            $fetchedCompanies = $query->fetchAll(\PDO::FETCH_ASSOC);

            $companiesArray = array();
            if (count($fetchedCompanies) > 0) {
                foreach ($fetchedCompanies as $c) {
                    $companiesArray[] = new Company($c['id'], $c['name']);
                }
            }
            return $companiesArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }
}