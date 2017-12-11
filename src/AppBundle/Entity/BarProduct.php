<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BarProduct
 *
 * @ORM\Table(name="bar_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BarProductRepository")
 */
class BarProduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=80, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=80, nullable=false)
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="payload", type="string", length=100, nullable=false)
     */
    private $payload;

    /**
     * @var float
     *
     * @ORM\Column(name="tax", type="float", precision=10, scale=0, nullable=false)
     */
    private $tax;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="capacity", type="string", length=10, nullable=false)
     */
    private $capacity;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=50, nullable=false)
     */
    private $location;

    /**
     * @var \AppBundle\Entity\BarMenu
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BarMenu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bar_menu_id", referencedColumnName="id")
     * })
     */
    private $barMenu;



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
     * Set title
     *
     * @param string $title
     *
     * @return BarProduct
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return BarProduct
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set payload
     *
     * @param string $payload
     *
     * @return BarProduct
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Get payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Set tax
     *
     * @param float $tax
     *
     * @return BarProduct
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return BarProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set capacity
     *
     * @param string $capacity
     *
     * @return BarProduct
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return string
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return BarProduct
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set barMenu
     *
     * @param \AppBundle\Entity\BarMenu $barMenu
     *
     * @return BarProduct
     */
    public function setBarMenu(\AppBundle\Entity\BarMenu $barMenu = null)
    {
        $this->barMenu = $barMenu;

        return $this;
    }

    /**
     * Get barMenu
     *
     * @return \AppBundle\Entity\BarMenu
     */
    public function getBarMenu()
    {
        return $this->barMenu;
    }
}
