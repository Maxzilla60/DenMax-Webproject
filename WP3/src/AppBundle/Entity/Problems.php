<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Problems
 *
 * @ORM\Table(name="problems", indexes={@ORM\Index(name="fk_location_id_idx", columns={"location_id"})})
 * @ORM\Entity
 */
class Problems
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=130, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fixed", type="boolean", nullable=false)
     */
    private $fixed;

    /**
     * @var integer
     *
     * @ORM\Column(name="technician", type="integer", nullable=true)
     */
    private $technician;

    /**
     * @var \Locations
     *
     * @ORM\ManyToOne(targetEntity="Locations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Problems
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Problems
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set fixed
     *
     * @param boolean $fixed
     *
     * @return Problems
     */
    public function setFixed($fixed)
    {
        $this->fixed = $fixed;

        return $this;
    }

    /**
     * Get fixed
     *
     * @return boolean
     */
    public function getFixed()
    {
        return $this->fixed;
    }

    /**
     * Set technician
     *
     * @param integer $technician
     *
     * @return Problems
     */
    public function setTechnician($technician)
    {
        $this->technician = $technician;

        return $this;
    }

    /**
     * Get technician
     *
     * @return integer
     */
    public function getTechnician()
    {
        return $this->technician;
    }

    /**
     * Set location
     *
     * @param \AppBundle\Entity\Locations $location
     *
     * @return Problems
     */
    public function setLocation(\AppBundle\Entity\Locations $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \AppBundle\Entity\Locations
     */
    public function getLocation()
    {
        return $this->location;
    }
}
