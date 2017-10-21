<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Model\User;
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

    /**
     * PAGE: add
     */
    public function add() {
        // Checken of we inderdaad iets posten en of de body juist is ingesteld:
        if (isset($_POST['name']) && isset($_POST['role'])) {
            $this->repository->addUser(new User(0, $_POST['name'], $_POST['role']));
        }

        // Redirect
        header('location: ' . URL . 'users');
    }

    /*
     * PAGE: updateTechnician
     */
    public function update($user_id) {
        // Checken of we inderdaad iets posten en of de body juist is ingesteld:
        if (isset($_POST['name']) && isset($_POST['role'])) {
            $this->repository->updateUser($user_id, $_POST['name'], $_POST['role']);
        }

        // Redirect
        header('location: ' . URL . 'users');
    }

    /*
    * PAGE: deleteTechnician
    */
    public function deleteTechnician($problem_id) {
        $this->repository->deleteTechnician($problem_id);

        // Redirect
        header('location: ' . URL . 'problems');
    }
}