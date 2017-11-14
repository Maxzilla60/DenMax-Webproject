<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Problemreactions
 *
 * @ORM\Table(name="problemreactions", indexes={@ORM\Index(name="fk_problem_id_idx", columns={"problem_id"})})
 * @ORM\Entity
 */
class Problemreactions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rating", type="boolean", nullable=false)
     */
    private $rating;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @var \Problems
     *
     * @ORM\ManyToOne(targetEntity="Problems")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="problem_id", referencedColumnName="id")
     * })
     */
    private $problem;


}

