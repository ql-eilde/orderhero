<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BarOrderItem
 *
 * @ORM\Table(name="bar_order_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BarOrderItemRepository")
 */
class BarOrderItem
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
     * @var \AppBundle\Entity\BarOrder
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BarOrder")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bar_order_id", referencedColumnName="id")
     * })
     */
    private $barOrder;

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
     * @return BarOrderItem
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
     * @return BarOrderItem
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
     * Set barOrder
     *
     * @param \AppBundle\Entity\BarOrder $barOrder
     *
     * @return BarOrderItem
     */
    public function setBarOrder(\AppBundle\Entity\BarOrder $barOrder = null)
    {
        $this->barOrder = $barOrder;

        return $this;
    }

    /**
     * Get barOrder
     *
     * @return \AppBundle\Entity\BarOrder
     */
    public function getBarOrder()
    {
        return $this->barOrder;
    }

    /**
     * Set barProduct
     *
     * @param \AppBundle\Entity\BarProduct $barProduct
     *
     * @return BarOrderItem
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
