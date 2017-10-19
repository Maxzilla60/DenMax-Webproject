<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 10.10.17
 * Time: 16:51
 */

namespace Mini\Model;

use Mini\Core\Model;


class PDOUserRepository extends Model
{
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $query = $this->db->prepare($sql);
        $query->execute();
        $fetchedUsers = $query->fetchAll(\PDO::FETCH_ASSOC);

        $userArray = array();
        if (count($fetchedUsers) > 0) {
            foreach ($fetchedUsers as $u) {
                $userArray[] = new User($u['id'], $u['name'], $u['role']);
            }
        }

        return $userArray;
    }

    public function getUsersByRole($role)
    {
        $sql = "SELECT * FROM users WHERE role = :role";
        $query = $this->db->prepare($sql);
        $parameters = array(':role' => $role);
        $query->execute($parameters);
        $fetchedUsers = $query->fetchAll(\PDO::FETCH_ASSOC);

        $userArray = array();
        if (count($fetchedUsers) > 0) {
            foreach ($fetchedUsers as $u) {
                $userArray[] = new User($u['id'], $u['name'], $u['role']);
            }
        }

        return $userArray;
    }
}