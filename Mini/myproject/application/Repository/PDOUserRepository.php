<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 10.10.17
 * Time: 16:51
 */

namespace Mini\Repository;

use Mini\Core\Model;
use Mini\Dao\PDOUserDAO;
use Mini\Model\User;

class PDOUserRepository extends Model
{
    private $userDAO;

    public function __construct(PDOUserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }
    public function getAllUsers()
    {
        $users = $this->userDAO->getAllUsers();
        return $users;
    }

    public function getUsersByRole($role)
    {
        $users = $this->userDAO->getUsersByRole($role);
        return $users;
    }

    public function addUser(User $user) {
        $this->userDAO->addUser($user);
    }

    public function updateUser($user_id, $name, $role) {
        $this->userDAO->updateUser($user_id, $name, $role);
    }

    public function deleteUser($user_id) {
        $this->userDAO->deleteUser($user_id);
    }

    private function isValidId($id)
    {
        if (is_string($id) && ctype_digit(trim($id))) {
            $id=(int)$id;
        }
        return is_integer($id) and $id >= 0;
    }
}