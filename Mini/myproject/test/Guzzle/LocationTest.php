<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 12:20
 */

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class LocationTest extends TestCase
{
    const IP='http://192.168.33.11/';
    public function setUp()
    {
        $this->client = new Client();
    }

    public function tearDown()
    {
        $this->client=null;
    }

    public function testGetAll_Status200LocationsArray()
    {
        $id = "1";
        $name = "Lokaal 1";
        $company_id = "1";
        $response = $this->client->get(self::IP . "guzzleLocations");
        $statuscode = $response->getStatusCode();
        $body = $response->getBody();
        $jsonArray = json_decode($body, true);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
        $this->assertEquals('200', $statuscode);
        $this->assertEquals($id, $jsonArray[0]["id"]);
        $this->assertEquals($name, $jsonArray[0]["name"]);
        $this->assertEquals($company_id, $jsonArray[0]["company_id"]);
    }

    public function testGetById_validId_Status200LocationObject(){
        $id = "2";
        $name = "Lokaal 2";
        $company_id = "1";
        $response = $this->client->get(self::IP . "guzzleLocations/id/2");
        $statuscode = $response->getStatusCode();
        $body = $response->getBody();
        $jsonArray = json_decode($body, true);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
        $this->assertEquals('200', $statuscode);
        $this->assertEquals($id, $jsonArray[0]["id"]);
        $this->assertEquals($name, $jsonArray[0]["name"]);
        $this->assertEquals($company_id, $jsonArray[0]["company_id"]);
    }

    public function testAdd_LocationObject_Status200ExtraObject(){
        $oldresponse = $this->client->get(self::IP . "guzzleLocations");
        $oldbody = $oldresponse->getBody();
        $oldjsonArray = json_decode($oldbody, true);
        $oldCount = count($oldjsonArray);


        $response = $this->client->post(self::IP . "guzzleLocations/add",[
            GuzzleHttp\RequestOptions::JSON => ["id"=> "3", "name" => "Lokaal 3", "company_id" => "2"]
        ]);


        $newresponse = $this->client->get(self::IP . "guzzleLocations");
        $newbody = $newresponse->getBody();
        $newjsonArray = json_decode($newbody, true);
        $newCount = count($newjsonArray);


        $this->assertEquals($oldCount + 1, $newCount);
    }

    public function testByCompany_ValidId_Status200LocationArray(){
        $count = 3;
        $company_id = "1";
        $response = $this->client->get(self::IP . "guzzleLocations/company/1");
        $statuscode = $response->getStatusCode();
        $body = $response->getBody();
        $jsonArray = json_decode($body, true);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
        $this->assertEquals('200', $statuscode);

        $this->assertEquals($count, count($jsonArray));
        $this->assertEquals($company_id, $jsonArray[0]["company_id"]);
        $this->assertEquals($company_id, $jsonArray[1]["company_id"]);
        $this->assertEquals($company_id, $jsonArray[2]["company_id"]);
    }
}
