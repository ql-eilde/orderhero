<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\BarCart;

class BarCartRepository extends EntityRepository
{
    private $newCart;

    public function __construct(BarCart $cart)
    {
        parent::__construct();
        $this->newCart = $cart;
    }

    public function userHasCart($psid)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT bc.id
            FROM AppBundle:BarCart bc
            WHERE bc.customerId = :psid'
        )->setParameter('psid', $psid);

        $response = $query->getResult();

        if(count($response) === 0) {
            return false;
        }
        return true;
    }

    public function addToCart($sender, $product)
    {
        $cart = $this->getCart($sender);
        $this->setCartItem($product, $cart['id']);
        $this->setCartTotal($cart);
    }

    public function getCart($sender)
    {
        $sender = intval($sender);
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT *
            FROM AppBundle:BarCart bc
            WHERE bc.customerId = :psid'
        )->setParameter('psid', $sender);
        
        return $query->getResult();
    }

    public function setCart($sender, $timestamp, $table_id)
    {
        $em = $this->getEntityManager();

        $this->newCart->setCustomerId($sender);
        $this->newCart->setTableId($tableId);
        $this->newCart->setTimestamp($timestamp);

        $em->persist($this->newCart);
        $em->flush();
    }
}