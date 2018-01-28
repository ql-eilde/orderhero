<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\BarCart;
use AppBundle\Entity\BarCartItem;
use AppBundle\Entity\BarProduct;

class BarCartItemRepository extends EntityRepository
{
    // public function getCartItems(BarCart $cart)
    // {
    //     $em = $this->getEntityManager()->getRepository('AppBundle:BarCartItem');

    // }

    public function setCartItem(BarProduct $product, BarCart $cart)
    {
        $em = $this->getEntityManager();
        $newCartItem = new BarCartItem();

        $newCartItem->setQuantity(1);
        $newCartItem->setTotal($product->getPrice());
        $newCartItem->setBarProduct($product);
        $newCartItem->setBarCart($cart);

        $em->persist($newCartItem);
        $em->flush();
    }

    public function deleteCartItems(BarCart $cart)
    {
        //
    }
}