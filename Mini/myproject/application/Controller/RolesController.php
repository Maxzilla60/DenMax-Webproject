<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Dao\PDORoleDAO;
use Mini\Repository\PDORoleRepository;
use Mini\View\RoleJsonView;

class RolesController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDORoleRepository(new PDORoleDAO());
        }
        if(!isset($view)) {
            $this->view = new RoleJsonView();
        }

    }

    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        $role = $this->repository->getAllRoles();
        $this->view->ShowAll($role);
    }
}