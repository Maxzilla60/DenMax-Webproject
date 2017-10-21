<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 10.10.17
 * Time: 16:51
 */

namespace Mini\Repository;

use Mini\Core\Model;
use Mini\Model\User;

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

    public function addUser(User $user) {
        try {
            $sql = "INSERT INTO users (name, role) VALUES (:name, :role)";
            $query = $this->db->prepare($sql);
            $parameters = array(':name' => $user->getName(), ':role' => $user->getRole());

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo 'Exception!: ' . $e->getMessage();
        }
    }

    public function updateUser($user_id, $name, $role) {
        try {
            $sql = "UPDATE users SET name = :name, role = :role WHERE id = :id";
            $query = $this->db->prepare($sql);
            $parameters = array(':name' => $name, ':role' => $role, ':id' => $user_id);

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $e) {
            http_response_code(400);
            echo 'Exception!: ' . $e->getMessage();
        }
    }
}