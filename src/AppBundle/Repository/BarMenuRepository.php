<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BarMenuRepository extends EntityRepository
{
    public function getMenuPayloads()
    {
        $query = $this->_em->createQuery(
            'SELECT bm.payload
            FROM AppBundle:BarMenu bm'
        );

        $results = $query->getResult();

        foreach($results as $result) {
            $menuPayloads[] = $result['payload'];
        }

        return $menuPayloads;
    }

    public function getMenu($location)
    {
        $query = $this->_em->createQuery(
            'SELECT bm.title, bm.subtitle, bm.payload
            FROM AppBundle:BarMenu bm
            WHERE bm.location = :loc'
        )->setParameter('loc', $location);

        $menu = $query->getResult();

        return $menu;
    }

    public function getMenuLocations()
    {
        $query = $this->_em->createQuery(
            'SELECT DISTINCT bm.location
            FROM AppBundle:BarMenu bm'
        );

        $results = $query->getResult();

        foreach($results as $result) {
            $locations[] = $result['location'];
        }

        return $locations;
    }
}