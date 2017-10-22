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
        // JSON ophalen en decoden:
        $input = file_get_contents('php://input');
        $inputJSON = json_decode($input, TRUE);

        // Checken of we de juiste data hebben meegekregen:
        if (isset($inputJSON['name']) && isset($inputJSON['role'])) {
            $this->repository->addUser(new User(0, $inputJSON['name'], $inputJSON['role']));
        }

        // Redirect (headers)
        header("access-control-allow-origin: *");
        header('location: ' . URL . 'users');
    }

    /*
     * PAGE: updateTechnician
     */
    public function update($user_id) {
        // JSON ophalen en decoden:
        $input = file_get_contents('php://input');
        $inputJSON = json_decode($input, TRUE);

        // Checken of we de juiste data hebben meegekregen:
        if (isset($inputJSON['name']) && isset($inputJSON['role'])) {
            $this->repository->updateUser($user_id, $inputJSON['name'], $inputJSON['role']);
        }

        // Redirect (headers)
        header("access-control-allow-origin: *");
        header('location: ' . URL . 'users');
    }

    /*
    * PAGE: deleteTechnician
    */
    public function delete($user_id) {
        $this->repository->deleteUser($user_id);

        // Redirect (headers)
        header("access-control-allow-origin: *");
        header('location: ' . URL . 'users');
    }
}