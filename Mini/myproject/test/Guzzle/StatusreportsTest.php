<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 07.11.17
 * Time: 15:32
 */

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;


class StatusreportsTest extends TestCase
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

    public function testGetAll_Status200StatusReportsArray()
    {
        $id = "3";
        $location_id = "3";
        $status = "1";
        $date = "2000-01-01 00:00:00";
        $response = $this->client->get(self::IP . "guzzleStatusreports");
        $statuscode = $response->getStatusCode();
        $body = $response->getBody();
        $jsonArray = json_decode($body, true);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
        $this->assertEquals('200', $statuscode);
        $this->assertEquals($id, $jsonArray[0]["id"]);
        $this->assertEquals($location_id, $jsonArray[0]["location_id"]);
        $this->assertEquals($status, $jsonArray[0]["status"]);
        $this->assertEquals($date, $jsonArray[0]["date"]);
    }

    public function testGetById_Status200StatusReportsArray()
    {
        $id = "4";
        $location_id = "2";
        $status = "2";
        $date = "2000-01-02 00:00:00";
        $response = $this->client->get(self::IP . "guzzleStatusreports/id/4");
        $statuscode = $response->getStatusCode();
        $body = $response->getBody();
        $jsonArray = json_decode($body, true);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
        $this->assertEquals('200', $statuscode);
        $this->assertEquals($id, $jsonArray[0]["id"]);
        $this->assertEquals($location_id, $jsonArray[0]["location_id"]);
        $this->assertEquals($status, $jsonArray[0]["status"]);
        $this->assertEquals($date, $jsonArray[0]["date"]);
    }

    public function testAdd_LocationObject_Status200ExtraObject(){
        $oldresponse = $this->client->get(self::IP . "guzzleStatusreports");
        $oldbody = $oldresponse->getBody();
        $oldjsonArray = json_decode($oldbody, true);
        $oldCount = count($oldjsonArray);


        $response = $this->client->post(self::IP . "guzzleStatusreports/add",[
            GuzzleHttp\RequestOptions::JSON =>
                ["id"=> "1", "location_id" => "3", "status" => "2", "date" => "2000-01-02 00:00:00"]
        ]);


        $newresponse = $this->client->get(self::IP . "guzzleStatusreports");
        $newbody = $newresponse->getBody();
        $newjsonArray = json_decode($newbody, true);
        $newCount = count($newjsonArray);


        $this->assertEquals($oldCount + 1, $newCount);
    }

    public function testByLocation_ValidId_Status200LocationArray(){
        $count = 3;
        $location_id = "2";
        $response = $this->client->get(self::IP . "guzzleStatusreports/location/2");
        $statuscode = $response->getStatusCode();
        $body = $response->getBody();
        $jsonArray = json_decode($body, true);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
        $this->assertEquals('200', $statuscode);

        $this->assertEquals($count, count($jsonArray));
        $this->assertEquals($location_id, $jsonArray[0]["location_id"]);
        $this->assertEquals($location_id, $jsonArray[1]["location_id"]);
        $this->assertEquals($location_id, $jsonArray[2]["location_id"]);
    }
}
