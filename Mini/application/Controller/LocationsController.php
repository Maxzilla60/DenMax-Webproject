<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Model\Location;
use Mini\Repository\PDOLocationRepository;
use Mini\View\LocationJsonView;

class LocationsController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDOLocationRepository();
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
        // Checken of we inderdaad iets posten en of de body juist is ingesteld:
        if (isset($_POST['name']) && isset($_POST['company_id'])) {
            $this->repository->addLocation(new Location(0, $_POST['name'], $_POST['company_id']));
        }

        // Redirect
        header('location: ' . URL . 'locations');
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