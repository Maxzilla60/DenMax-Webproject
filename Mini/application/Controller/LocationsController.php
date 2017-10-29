<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Dao\DaoException;
use Mini\Model\Location;
use Mini\Repository\PDOLocationRepository;
use Mini\View\LocationJsonView;
use Mini\Dao\PDOLocationDAO;

class LocationsController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDOLocationRepository(new PDOLocationDAO());
        }
        if(!isset($view)) {
            $this->view = new LocationJsonView();
        }

    }


    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        $locations = $this->repository->getAllLocations();
        $this->view->ShowAll($locations);
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
            if (isset($inputJSON['name']) && isset($inputJSON['company_id'])) {
                $this->repository->addLocation(new Location(0, $inputJSON['name'], $inputJSON['company_id']));
                http_response_code(200);
            } else {
                http_response_code(400);
                echo 'wrong input';
            }

            // Redirect (headers)
            header("access-control-allow-methods: *");
            header("access-control-allow-origin: *");
            header('Location: ' . URL . 'locations', true, 200);
        } catch (DaoException $exception) {
            http_response_code(400);
            echo $exception;
        }
    }

    /**
     * PAGE: company
     * @param int $id
     */
    public function company($id)
    {
        // load views
        $locations = $this->repository->getLocationsByCompany($id);
        $this->view->ShowAll($locations);
    }
}