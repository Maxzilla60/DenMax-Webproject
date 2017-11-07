<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 12.10.17
 * Time: 11:36
 */

namespace Mini\Controller;

use Mini\Dao\PDOCompanyDAO;
use Mini\Repository\PDOCompanyRepository;
use Mini\View\CompanyJsonView;

class CompaniesController
{
    private $repository;
    private $view;

    function __construct($repo = null, $view = null)
    {
        if(!isset($repo)) {
            $this->repository = new PDOCompanyRepository(new PDOCompanyDAO());
        }
        if(!isset($view)) {
            $this->view = new CompanyJsonView();
        }

    }


    /**
     * PAGE: index
     */
    public function index()
    {
        // load views
        $companies = $this->repository->getAllCompanies();
        $this->view->ShowAll($companies);
    }

    /**
     * PAGE: user
     * @param int $id Id of the the user
     */
    public function user($id)
    {
        // load views
        $company = $this->repository->getCompanyByUser($id);
        $this->view->ShowAll($company);
    }
}