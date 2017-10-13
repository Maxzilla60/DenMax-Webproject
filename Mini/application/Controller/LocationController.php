<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Model\PDOLocationRepository;
use Mini\View\LocationJsonView;

class LocationController
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
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load views
        $locations = $this->repository->getAllLocations();
        $this->view->ShowAll($locations);
    }

    /**
     * PAGE: company
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     * @param int $id Id of the to-edit song
     */
    public function company($id)
    {
        // load views
        $locations = $this->repository->getLocationsByCompany($id);
        $this->view->ShowAll($locations);
    }
}