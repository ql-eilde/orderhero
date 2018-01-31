<?php

namespace AppBundle\Service;

use AppBundle\Service\Template;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\BarCart;

class Webhook
{
    private $template;
    private $container;
    private $barCartRepo;
    private $barCartItemRepo;
    private $barMenuRepo;
    private $barProductRepo;

    public function __construct(Template $template, ContainerInterface $container)
    {
        $this->template = $template;
        $this->container = $container;
        $this->barCartRepo = $container->get('doctrine')->getRepository('AppBundle:BarCart');
        $this->barCartItemRepo = $container->get('doctrine')->getRepository('AppBundle:BarCartItem');
        $this->barMenuRepo = $container->get('doctrine')->getRepository('AppBundle:BarMenu');
        $this->barProductRepo = $container->get('doctrine')->getRepository('AppBundle:BarProduct');
    }

    public function handleMessage(BarCart $cart, $message)
    {
        $psid = $cart->getCustomerId();
        switch(strtolower($message)) {
            case 'carte':
                $getMenu = $this->barMenuRepo->getMenu("first_menu");
                $response = $this->template->showMenu($getMenu, "first_menu");
                break;
            default:
                $response = $this->template->defaultResponse();
        }

        $this->reply($response, $psid);
    }

    public function handlePostback(BarCart $cart, $payload)
    {
        $psid = $cart->getCustomerId();
        switch($payload) {
            case 'conversation_started':
                $response = $this->template->welcomeMessage();
                break;
            case 'YesShowMeTheMenu':
            case 'anotherDrink':
                $getMenu = $this->barMenuRepo->getMenu("first_menu");
                $response = $this->template->showMenu($getMenu, "first_menu");
                break;
            case 'DontShowMeTheMenu':
                $response = $this->template->dontShowMenu();
                break;
            case 'payMyOrder':
                $total = $this->barCartRepo->getTotalOfCart($cart);
                $response = $this->template->payOrder($cart);
                break;
            default:
                break;
        }
        if(!isset($response)) {
            // TODO: Gerer les fin de menus et produits
            $menuPayloads = $this->barMenuRepo->getMenuPayloads();
            $menuLocations = $this->barMenuRepo->getMenuLocations();
            $productsPayloads = $this->barProductRepo->getProductsPayloads();
            $productsLocations = $this->barProductRepo->getProductsLocations();
            switch(true) {
                case in_array($payload, $menuPayloads):
                    $location = "first_page:".$payload;
                    $getProducts = $this->barProductRepo->getProducts($payload);
                    $response = $this->template->showProducts($getProducts, $location, $payload);
                    break;
                case in_array($payload, $menuLocations):
                    $getMenu = $this->barMenuRepo->getMenu($payload);
                    $response = $this->template->showMenu($getMenu, $payload);
                    break;
                case in_array($payload, $productsLocations):
                    $show = explode(":", $payload);
                    $getProducts = $this->barProductRepo->getProducts($payload);
                    $response = $this->template->showProducts($getProducts, $payload, $show[1]);
                    break;
                case in_array($payload, $productsPayloads):
                    $product = $this->barProductRepo->findOneByPayload($payload);
                    $this->barCartRepo->addToCart($cart, $product);
                    $total = $this->barCartRepo->getTotalOfCart($cart);
                    $response = $this->template->anotherDrink($cart);
                    break;
                default:
                    $response = ["text"=>"Fin du menu."];
            }
        }
        $this->reply($response, $psid);
    }

    public function typingOn($psid)
    {
        $message = [
            "recipient"=>[
                "id"=>$psid
            ],
            "sender_action"=>"typing_on"
        ];

        $access_token = $this->container->getParameter('access_token');
        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
        curl_exec($ch);
    }

    public function reply($response, $psid)
    {
        $message = [
            "messaging_type"=>"RESPONSE",
            "recipient"=>[
                "id"=>$psid
            ],
            "message"=>$response
        ];
    
        $access_token = $this->container->getParameter('access_token');
        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
        curl_exec($ch);
    }
}