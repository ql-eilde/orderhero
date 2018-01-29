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
        //
    }
}