<?php

/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 27.10.17
 * Time: 10:09
 */
namespace Mini\Dao;

use Mini\Core\Model;
use Mini\Model\User;

class PDOUserDAO extends Model
{
    function __construct(\PDO $connection = null)
    {
        if($connection != null){
            $this->db = $connection;
        } else {
            parent::__construct();
        }
    }

    public function getAllUsers()
    {
        try {
            $sql = "SELECT * FROM users";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $query->execute();
            $fetchedUsers = $query->fetchAll(\PDO::FETCH_ASSOC);

            $userArray = array();
            if (count($fetchedUsers) > 0) {
                foreach ($fetchedUsers as $u) {
                    $userArray[] = new User($u['id'], $u['name'], $u['role']);
                }
            }

            return $userArray;
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function getUsersByRole($role)
    {
        try {
            $sql = "SELECT * FROM users WHERE role = :role";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
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
        } catch (\PDOException $exception) {
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function getUserByUsername($username)
    {
        try {
            $sql = "SELECT * FROM users WHERE name = :name LIMIT 1";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':name' => $username);
            $query->execute($parameters);
            $fetchedUsers = $query->fetchAll(\PDO::FETCH_ASSOC);

            $userArray = array();
            if (count($fetchedUsers) > 0) {
                foreach ($fetchedUsers as $u) {
                    $userArray[] = new User($u['id'], $u['name'], $u['role']);
                }
            }

            return $userArray;
        } catch (\PDOException $exception) {
           throw new DaoException("PDO Exception, 0, $exception"); 
        }
    }

    public function addUser(User $user) {
        try {
            $sql = "INSERT INTO users (name, role) VALUES (:name, :role)";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':name' => $user->getName(), ':role' => $user->getRole());

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            //http_response_code(400);
            //echo 'Exception!: ' . $e->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function updateUser($user_id, $name, $role) {
        try {
            $sql = "UPDATE users SET name = :name, role = :role WHERE id = :id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':name' => $name, ':role' => $role, ':id' => $user_id);

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            //http_response_code(400);
            //echo 'Exception!: ' . $e->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }

    public function deleteUser($user_id) {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $query = $this->db->prepare($sql);
            if($query == false) {
                throw new \PDOException("Problem with PDOStatement");
            }
            $parameters = array(':id' => $user_id);

            http_response_code(200);
            $query->execute($parameters);
        } catch (\PDOException $exception) {
            //http_response_code(400);
            //echo 'Exception!: ' . $e->getMessage();
            throw new DaoException("PDO Exception, 0, $exception");
        }
    }
}