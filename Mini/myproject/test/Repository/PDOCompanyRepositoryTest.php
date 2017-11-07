<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 11:23
 */

use Mini\Repository\PDOCompanyRepository;
use PHPUnit\Framework\TestCase;
use Mini\Model\Company;

class PDOCompanyRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->mockUserDAO = $this->getMockBuilder('Mini\Dao\PDOCompanyDAO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->mockUserDAO = null;
    }

    public function testGetAll_CompanyArray()
    {
        $companies = [];
        for ($i = 0; $i<5; $i++){
            $companies[] = new Company($i, "name");
        }
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getAllCompanies')
            ->will($this->returnValue($companies));
        $companyRepository = new PDOCompanyRepository($this->mockUserDAO);
        $actualCompany = $companyRepository->getAllCompanies();
        $this->assertEquals($companies, $actualCompany);
    }

    public function testGetByUser_CompanyArray()
    {
        $user_id = "1";
        $company = new Company(1, "name");
        $this->mockUserDAO->expects($this->atLeastOnce())
            ->method('getCompanyByUser')
            ->with($this->equalTo($user_id))
            ->will($this->returnValue($company));
        $companyRepository = new PDOCompanyRepository($this->mockUserDAO);
        $actualCompany = $companyRepository->getCompanyByUser($user_id);
        $this->assertEquals($company, $actualCompany);
    }
}
