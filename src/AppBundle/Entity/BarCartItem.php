<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BarCartItem
 *
 * @ORM\Table(name="bar_cart_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BarCartItemRepository")
 */
class BarCartItem
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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var \AppBundle\Entity\BarCart
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BarCart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bar_cart_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $barCart;

    /**
     * @var \AppBundle\Entity\BarProduct
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BarProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bar_product_id", referencedColumnName="id")
     * })
     */
    private $barProduct;



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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return BarCartItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return BarCartItem
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set barCart
     *
     * @param \AppBundle\Entity\BarCart $barCart
     *
     * @return BarCartItem
     */
    public function setBarCart(\AppBundle\Entity\BarCart $barCart = null)
    {
        $this->barCart = $barCart;

        return $this;
    }

    /**
     * Get barCart
     *
     * @return \AppBundle\Entity\BarCart
     */
    public function getBarCart()
    {
        return $this->barCart;
    }

    /**
     * Set barProduct
     *
     * @param \AppBundle\Entity\BarProduct $barProduct
     *
     * @return BarCartItem
     */
    public function setBarProduct(\AppBundle\Entity\BarProduct $barProduct = null)
    {
        $this->barProduct = $barProduct;

        return $this;
    }

    /**
     * Get barProduct
     *
     * @return \AppBundle\Entity\BarProduct
     */
    public function getBarProduct()
    {
        return $this->barProduct;
    }
}
