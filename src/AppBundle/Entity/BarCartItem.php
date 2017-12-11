<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BarCartItem
 *
 * @ORM\Table(name="bar_cart_item")
 * @ORM\Entity
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
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="tax", type="float", precision=10, scale=0, nullable=false)
     */
    private $tax;

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


}

