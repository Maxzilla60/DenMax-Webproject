<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:55
 */

namespace Mini\Repository;

use Mini\Core\Model;
use Mini\Model\Role;

class PDORoleRepository extends Model
{
    public function getAllRoles() {
        $sql = "SELECT * FROM roles";
        $query = $this->db->prepare($sql);
        $query->execute();
        $fetchedRoles = $query->fetchAll(\PDO::FETCH_ASSOC);

        $roleArray = array();
        if (count($fetchedRoles) > 0) {
            foreach ($fetchedRoles as $l) {
                $roleArray[] = new Role($l['id'], $l['rolename']);
            }
        }

        return $roleArray;
    }
}
