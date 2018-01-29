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
        $cartItemRepo->setCartItem($product, $cart->getId());
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
        $cartItemRepo = $this->_em->getRepository('AppBundle:BarCartItem');

        $cartItems = $cartItemRepo->findByBarCart($cart);

        $total_array = array();
        foreach($cartItems as $item) {
            $total_array[] = $item['total'];
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

        return $total;
    }
}