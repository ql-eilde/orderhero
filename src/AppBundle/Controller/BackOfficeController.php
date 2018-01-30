<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BackOfficeController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:BackOffice:index.html.twig', array());
    }

    /**
     * @Route("/commandes", name="orders")
     */
    public function ordersAction(Request $request)
    {
        if($request->isMethod('POST')) {
            $data = $request->request->get('id');
            $order = $this->getDoctrine()->getRepository('AppBundle:BarOrder')->findOneById($data);
            $em = $this->getDoctrine()->getManager();

            $order->setIsServed(true);
            $em->flush();
            return new Response();
        }
        $orders = $this->getDoctrine()->getRepository('AppBundle:BarOrder')->findByIsServed(false);

        return $this->render('AppBundle:BackOffice:orders.html.twig', array(
            "orders" => $orders,
        ));
    }

    /**
     * @Route("/details-commande", name="order")
     */
    public function orderAction(Request $request)
    {
        if($request->isMethod('POST')) {
            $id = $request->request->get('id');
            $order = $this->getDoctrine()->getRepository('AppBundle:BarOrder')->findById($id);
            $orderItems = $this->getDoctrine()->getRepository('AppBundle:BarOrderItem')->findByBarOrder($order);

            $string = "";
            foreach($orderItems as $orderItem) {
                $product = $orderItem->getBarProduct();
                $string .= "<li>".$product->getTitle()." - ".$product->getCapacity()."</li>";
            }

            return new Response($string);
        }
    }

    /**
     * @Route("/historique-commandes", name="orders_history")
     */
    public function ordersHistoryAction(Request $request)
    {
        $orders = $this->getDoctrine()->getRepository('AppBundle:BarOrder')->findByIsServed(true);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $orders,
            $request->query->get('page', 1),
            15
        );

        return $this->render('AppBundle:BackOffice:orders_history.html.twig', array(
            'orders' => $pagination
        ));
    }
}
