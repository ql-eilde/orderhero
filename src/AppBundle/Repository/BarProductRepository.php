<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BarProductRepository extends EntityRepository
{
    public function getProductsPayloads()
    {
        $query = $this->_em->createQuery(
            'SELECT bp.payload
            FROM AppBundle:BarProduct bp'
        );

        $results = $query->getResult();

        foreach($results as $result) {
            $productsPayloads[] = $result['payload'];
        }

        return $productsPayloads;
    }

    public function getProducts($payload)
    {
        if(preg_match("/^show/", $payload)) {
            $payload = "first_page:".$payload;
        }

        $query = $this->_em->createQuery(
            'SELECT bp.title, bp.subtitle, bp.price, bp.payload
            FROM AppBundle:BarProduct bp
            WHERE bp.location = :payload'
        )->setParameter('payload', $payload);

        $products = $query->getResult();

        return $products;
    }

    public function getProductsLocations()
    {
        $query = $this->_em->createQuery(
            'SELECT DISTINCT bp.location
            FROM AppBundle:BarProduct bp'
        );

        $results = $query->getResult();

        foreach($results as $result) {
            $productsLocations[] = $result['location'];
        }

        return $productsLocations;
    }
}