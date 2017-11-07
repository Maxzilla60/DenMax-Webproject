<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 15:28
 */

namespace Mini\Controller;

use Mini\Dao\DaoException;
use Mini\Dao\PDOStatusReportDAO;
use Mini\Model\StatusReport;
use Mini\Repository\PDOStatusReportRepository;
use Mini\View\StatusReportJsonView;
use PDO;

class GuzzleStatusreportsController extends StatusreportsController
{
    function __construct()
    {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        $this->view = new StatusReportJsonView();
        $this->repository = new PDOStatusReportRepository(new PDOStatusReportDAO(
            new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_GUZZLENAME, DB_USER, DB_PASS, $options)));
    }

    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        $statusreports = $this->repository->getAllStatusReports();
        $this->view->ShowAll($statusreports);
    }

    /**
     * PAGE: id
     */
    public function id($id)
    {
        // load views
        $statusreports = $this->repository->getStatusReportsById($id);
        $this->view->ShowAll($statusreports);
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
            if (isset($inputJSON['location_id']) && isset($inputJSON['status']) && isset($inputJSON['date'])) {
                $this->repository->addStatusReport(new StatusReport(0, $inputJSON['location_id'], $inputJSON['status'], $inputJSON['date']));
                http_response_code(200);
            } else {
                http_response_code(400);
                echo 'wrong input';
            }

            // Redirect (headers)
            header("access-control-allow-origin: *");
            header('location: ' . URL . 'statusreports', true, 200);
        } catch (DaoException $exception) {
            http_response_code(400);
            echo $exception;
        }
    }

    /**
     * PAGE: location
     * @param int $id
     */
    public function location($id)
    {
        // load views
        $statusreports = $this->repository->getStatusReportsByLocation($id);
        $this->view->ShowAll($statusreports);
    }
}