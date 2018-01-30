<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\BarCart;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Error\Card;

class PaymentController extends Controller
{
    /**
     * @Route("/pay/{cart}")
     */
    public function payAction(BarCart $cart, Request $request)
    {
        return $this->render('AppBundle:Pay:pay.html.twig', array(
            "cart" => $cart,
            "stripe_pk" => $this->getParameter('stripe_publishable_key')
        ));        
    }

    /**
     * @Route("/process/{cart}", name="process")
     */
    public function processAction(BarCart $cart, Request $request)
    {
        if($request->isMethod('POST')) {
            Stripe::setApiKey($this->getParameter('stripe_secret_key'));
            $token = $request->request->get('stripeToken');

            try {
                $charge = Charge::create(array(
                    "amount" => $cart->getTotal(),
                    "currency" => "eur",
                    "description" => "Paiement OrderHero",
                    "source" => $token,
                ));
                $barOrderRepo = $this->getDoctrine()->getRepository('AppBundle:BarOrder');
                $barOrderItemRepo = $this->getDoctrine()->getRepository('AppBundle:BarOrderItem');
                $barCartRepo = $this->getDoctrine()->getRepository('AppBundle:BarCart');
                $barCartItemRepo = $this->getDoctrine()->getRepository('AppBundle:BarCartItem');
                $order = $barOrderRepo->setOrder($cart, $charge->id);
                $cartItems = $barCartItemRepo->findByBarCart($cart);
                foreach($cartItems as $cartItem) {
                    $barOrderItemRepo->setOrderItem($cartItem, $order);
                }
                $barCartRepo->deleteCart($cart);
                return $this->render('AppBundle:Pay:success.html.twig', array(
                    "charge" => $charge->id,
                    "total" => $cart->getTotal(),
                ));
            } catch(Card $e) {
                $body = $e->getJsonBody();
                $erreur = $body['error'];
                return $this->render('AppBundle:Pay:failure.html.twig', array(
                    "erreur" => $erreur,
                    "cart" => $cart->getId(),
                ));
            }
        }
        return new Response();      
    }
}