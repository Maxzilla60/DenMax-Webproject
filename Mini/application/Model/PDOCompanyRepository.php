<?php

namespace Mini\Model;

use Mini\Core\Model;

class PDOCompanyRepository extends Model
{
    public function getAllCompanies() {
        $sql = "SELECT * FROM companies";
        $query = $this->db->prepare($sql);
        $query->execute();
        $fetchedCompanies = $query->fetchAll(\PDO::FETCH_ASSOC);

        $companiesArray = array();
        if (count($fetchedCompanies) > 0) {
            foreach ($fetchedCompanies as $c) {
                $companiesArray[] = new Company($c['id'], $c['name']);
            }
        }

        return $companiesArray;
    }


    public function getCompanyByUser($user_id) {
        $sql = "SELECT * FROM companies WHERE id IN (SELECT company_id FROM employees WHERE user_id = :user_id)";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);
        $query->execute($parameters);

        $fetchedCompany = $query->fetch(\PDO::FETCH_ASSOC);

        if (count($fetchedCompany) > 0) {
                $company = new Company($fetchedCompany['id'], $fetchedCompany['name']);
                return $company;
        }
        return null;
    }
}
