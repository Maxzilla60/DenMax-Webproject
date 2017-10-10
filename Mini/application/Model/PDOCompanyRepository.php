<?php

namespace Mini\Model;

use Mini\Core\Model;
use Company;

class PDOCompanyRepository extends Model
{
    public function getCompaniesByUser($user_id) {
        $sql = "SELECT * FROM locations WHERE id IN (SELECT company_id FROM employees WHERE user_id = :user_id)"; // TODO
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);
        $query->execute($parameters);
        $fetchedCompanies = $query->fetchAll();

        $companiesArray = array();
        if (count($fetchedCompanies) > 0) {
            foreach ($fetchedCompanies as $c) {
                $companiesArray[] = new Company($c['id'], $c['name']);
            }
        }

        return $companiesArray;
    }
}
