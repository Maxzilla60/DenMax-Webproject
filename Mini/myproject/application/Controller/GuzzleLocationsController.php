<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 13:58
 */

namespace Mini\Controller;


use Mini\Dao\PDOLocationDAO;
use Mini\Repository\PDOLocationRepository;
use Mini\View\LocationJsonView;
use Mini\Dao\DaoException;
use Mini\Model\Location;
use PDO;

class GuzzleLocationsController extends LocationsController
{
    function __construct()
    {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        $this->view = new LocationJsonView();
        $this->repository = new PDOLocationRepository(new PDOLocationDAO(
            new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_GUZZLENAME, DB_USER, DB_PASS, $options)));
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
     * PAGE: id
     */
    public function id($id)
    {
        // load views
        $locations = $this->repository->getLocationsById($id);
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