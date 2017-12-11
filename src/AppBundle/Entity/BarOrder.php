<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BarOrder
 *
 * @ORM\Table(name="bar_order")
 * @ORM\Entity
 */
class BarOrder
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
     * @ORM\Column(name="charge_id", type="string", length=255, nullable=false)
     */
    private $chargeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="customer_id", type="bigint", nullable=false)
     */
    private $customerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="timestamp", type="bigint", nullable=false)
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="table_id", type="integer", nullable=false)
     */
    private $tableId;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var bool
     * 
     * @ORM\Column(name="isServed", type="boolean", nullable=false)
     */
    private $isServed;


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
     * Set chargeId
     *
     * @param string $chargeId
     *
     * @return BarOrder
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;

        return $this;
    }

    /**
     * Get chargeId
     *
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return BarOrder
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set timestamp
     *
     * @param integer $timestamp
     *
     * @return BarOrder
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set tableId
     *
     * @param integer $tableId
     *
     * @return BarOrder
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;

        return $this;
    }

    /**
     * Get tableId
     *
     * @return integer
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return BarOrder
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
     * Set isServed
     *
     * @param boolean $isServed
     *
     * @return BarOrder
     */
    public function setIsServed($isServed)
    {
        $this->isServed = $isServed;

        return $this;
    }

    /**
     * Get isServed
     *
     * @return boolean
     */
    public function getIsServed()
    {
        return $this->isServed;
    }
}
