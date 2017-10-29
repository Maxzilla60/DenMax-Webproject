<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 10.10.17
 * Time: 16:32
 */

namespace Mini\Model;


class ProblemReaction
{
    private $id;
    private $problem_id;
    private $rating;
    private $description;

    /**
     * Problem constructor.
     * @param $id
     * @param $problem_id
     * @param $rating
     * @param $description
     */
    public function __construct($id, $problem_id, $rating, $description)
    {
        $this->id = $id;
        $this->problem_id = $problem_id;
        $this->rating = $rating;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProblemId()
    {
        return $this->problem_id;
    }

    /**
     * @param mixed $problem_id
     */
    public function setProblemId($problem_id)
    {
        $this->problem_id = $problem_id;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}