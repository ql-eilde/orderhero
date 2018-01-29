<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\BarCart;
use AppBundle\Entity\BarCartItem;
use AppBundle\Entity\BarProduct;

class BarCartRepository extends EntityRepository
{
    public function addToCart(BarCart $cart, BarProduct $product)
    {
        $cartItemRepo = $this->_em->getRepository('AppBundle:BarCartItem');
        $cartItemRepo->setCartItem($product, $cart);
        $this->setCartTotal($cart);
    }

    public function setCart($psid, $tableId)
    {
        $newCart = new BarCart();

        $newCart->setCustomerId($psid);
        $newCart->setTableId($tableId);
        $newCart->setTotal(0);

        $this->_em->persist($newCart);
        $this->_em->flush();

        return $newCart;
    }

    public function getCartTotal(BarCart $cart)
    {
        $query = $this->_em->createQuery(
            'SELECT bci.total
            FROM AppBundle:BarCartItem bci
            WHERE bci.barCart = :cart'
        )->setParameter('cart', $cart->getId());

        $results = $query->getResult();

        $total_array = array();
        foreach($results as $result) {
            $total_array[] = $result['total'];
        }
        $total = array_sum($total_array);
        
        return $total;
    }

    public function setCartTotal(BarCart $cart)
    {
        $total = $this->getCartTotal($cart);

        $cart->setTotal($total);
        $this->_em->flush();
    }

    public function deleteCart(BarCart $cart)
    {
        $this->_em->remove($cart);
        $this->_em->flush();
    }

    public function getTotalOfCart(BarCart $cart)
    {
        $query = $this->_em->createQuery(
            'SELECT bc.total
            FROM AppBundle:BarCart bc
            WHERE bc.customerId = :psid'
        )->setParameter('psid', $cart->getCustomerId());

        $total = $query->getResult();

        return $total[0]['total'];
    }
}