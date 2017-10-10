<?php

class StatusReport
{
    private $id;
    private $location_id;
    private $status;
    private $date;

    public function __construct($id, $location_id, $status, $date)
    {
        $this->id = $id;
        $this->location_id = $location_id;
        $this->status = $status;
        $this->date = $date;
    }

    public function toJSON() {
        //TODO
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLocationId()
    {
        return $this->location_id;
    }

    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}
