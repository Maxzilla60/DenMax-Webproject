<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Dao\DaoException;
use Mini\Dao\PDOUserDAO;
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
            $this->repository = new PDOUserRepository(new PDOUserDAO());
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
     * PAGE: id
     */
    public function id($id)
    {
        // load views
        $users = $this->repository->getUsersById($id);
        $this->view->ShowAll($users);
    }

    /**
     * PAGE: username
     * @param int $id
     */
    public function username($username)
    {
        // load views
        $users = $this->repository->getUserbyUsername($username);
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
        try {
            // JSON ophalen en decoden:
            $input = file_get_contents('php://input');
            $inputJSON = json_decode($input, TRUE);

            // Checken of we de juiste data hebben meegekregen:
            if (isset($inputJSON['name']) && isset($inputJSON['role'])) {
                $this->repository->addUser(new User(0, $inputJSON['name'], $inputJSON['role']));
                http_response_code(200);
            } else {
                http_response_code(400);
                echo 'wrong input';
            }

            // Redirect (headers)
            header("access-control-allow-origin: *");
            header('location: ' . URL . 'users', true, 200);
        } catch (DaoException $exception) {
            http_response_code(400);
            echo $exception;
        }
    }

    /*
     * PAGE: updateTechnician
     */
    public function update($user_id) {
        try {
            // JSON ophalen en decoden:
            $input = file_get_contents('php://input');
            $inputJSON = json_decode($input, TRUE);

            // Checken of we de juiste data hebben meegekregen:
            if (isset($inputJSON['name']) && isset($inputJSON['role'])) {
                $this->repository->updateUser($user_id, $inputJSON['name'], $inputJSON['role']);
                http_response_code(200);
            } else {
                http_response_code(400);
                echo 'wrong input';
            }

            // Redirect (headers)
            header("access-control-allow-origin: *");
            header('location: ' . URL . 'users', true, 200);
        } catch (DaoException $exception) {
            http_response_code(400);
            echo $exception;
        }
    }

    /*
    * PAGE: deleteTechnician
    */
    public function delete($user_id) {
        try {
            $this->repository->deleteUser($user_id);
            http_response_code(200);

            // Redirect (headers)
            header("access-control-allow-origin: *");
            header('location: ' . URL . 'users', true, 200);
        }catch (DaoException $exception) {
            http_response_code(400);
            echo $exception;
        }
    }
}