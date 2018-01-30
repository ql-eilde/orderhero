<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\BarCart;
use AppBundle\Entity\BarOrder;

class BarOrderRepository extends EntityRepository
{
    public function setOrder(BarCart $cart, $charge)
    {
        $order = new BarOrder();

        $order->setChargeId($charge);
        $order->setCustomerId($cart->getCustomerId());
        $order->setTableId($cart->getTableId());
        $order->setTotal($cart->getTotal());
        $order->setIsServed(false);

        $this->_em->persist($order);
        $this->_em->flush();

        return $order;
    }
}