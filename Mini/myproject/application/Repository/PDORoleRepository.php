<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 13.10.17
 * Time: 11:55
 */

namespace Mini\Repository;

use Mini\Core\Model;
use Mini\Dao\PDORoleDAO;

class PDORoleRepository extends Model
{
    private $roleDAO;

    public function __construct(PDORoleDAO $roleDAO)
    {
        $this->roleDAO = $roleDAO;
    }

    public function getAllRoles() {
        $roles = $this->roleDAO->getAllRoles();
        return $roles;
    }
}
