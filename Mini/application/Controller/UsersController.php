<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Repository\PDOUserRepository;
use Mini\View\UserJsonView;

class UsersController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDOUserRepository();
        }
        if(!isset($view)) {
            $this->view = new UserJsonView();
        }

    }


    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        $users = $this->repository->getAllUsers();
        $this->view->ShowAll($users);
    }

    /**
     * PAGE: role
     * @param int $id
     */
    public function role($id)
    {
        // load views
        $users = $this->repository->getUsersByRole($id);
        $this->view->ShowAll($users);
    }
}