<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BarMenu
 *
 * @ORM\Table(name="bar_menu")
 * @ORM\Entity
 */
class BarMenu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=50, nullable=false)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=80, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=80, nullable=false)
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="payload", type="string", length=100, nullable=false)
     */
    private $payload;


}

