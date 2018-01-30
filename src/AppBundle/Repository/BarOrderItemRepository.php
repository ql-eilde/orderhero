<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\BarCartItem;
use AppBundle\Entity\BarOrderITem;
use AppBundle\Entity\BarOrder;

class BarOrderItemRepository extends EntityRepository
{
    public function setOrderItem(BarCartItem $cartItem, BarOrder $order)
    {
        $orderItem = new BarOrderItem();

        $orderItem->setQuantity($cartItem->getQuantity());
        $orderItem->setTotal($cartItem->getTotal());
        $orderItem->setBarOrder($order);
        $orderItem->setBarProduct($cartItem->getBarProduct());

        $this->_em->persist($orderItem);
        $this->_em->flush();
    }
}