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

        $menuPayloads = $query->getResult();

        foreach($menuPayloads as $menuPayload) {
            $final[] = $menuPayload['payload'];
        }

        return $final;
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

    public function getLocations()
    {
        $query = $this->_em->createQuery(
            'SELECT DISTINCT bm.location
            FROM AppBundle:BarMenu bm'
        );

        $locations = $query->getResult();

        return $locations;
    }
}