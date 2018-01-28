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
        $em = $this->getEntityManager();
        $cartItemRepo = $em->getRepository('AppBundle:BarCartItem');
        $cartItemRepo->setCartItem($product, $cart->getId());
        $this->setCartTotal($cart);
    }

    public function setCart($psid, $table_id)
    {
        $em = $this->getEntityManager();
        $newCart = new BarCart();

        $newCart->setCustomerId($psid);
        $newCart->setTableId($tableId);

        $em->persist($newCart);
        $em->flush();

        return $newCart;
    }

    public function getCartTotal(BarCart $cart)
    {
        $em = $this->getEntityManager();
        $cartItemRepo = $em->getRepository('AppBundle:BarCartItem');

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
        $em = $this->getEntityManager();
        $total = $this->getCartTotal($cart);

        $cart->setTotal($total);
        $em->flush();
    }

    public function deleteCart(BarCart $cart)
    {
        $em = $this->getEntityManager();

        $em->remove($cart);
        $em->flush();
    }
}