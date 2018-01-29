<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\BarCart;

class PaymentController extends Controller
{
    /**
     * @Route("/pay/{cartId}")
     */
    public function payAction(BarCart $cartId)
    {
        return new Response();
    }
}