<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\Webhook;

class WebhookController extends Controller
{
    /**
     * @Route("/webhook-test")
     */
    public function indexAction(Webhook $webhook)
    {
        // Vérification du webhook
        // $access_token = $this->container->getParameter('access_token');
        // $verify_token = $this->container->getParameter('verify_token');

        // $hub_verify_token = null;

        // if(isset($_REQUEST['hub_challenge'])) {
        //     $challenge = $_REQUEST['hub_challenge'];
        //     $hub_verify_token = $_REQUEST['hub_verify_token'];
        // }

        // if($hub_verify_token === $verify_token) {
        //     return new Response($challenge);
        // }
        // Fin vérification du webhook

        $input = json_decode(file_get_contents('php://input'), true);

        $psid= $input['entry'][0]['messaging'][0]['sender']['id'];
        $cartRepo = $this->getDoctrine()->getRepository('AppBundle:BarCart');
        $cart = $cartRepo->findOneByCustomerId($psid);

        if(isset($input['entry'][0]['messaging'][0]['message'])) {
            if(empty($cart)) {
                $response = ["text"=>"Veuillez tout d'abord scanner un code messenger. C'est pour mieux vous servir mon enfant!"];
                $webhook->reply($response, $psid);
            } else {
                $message = $input['entry'][0]['messaging'][0]['message']['text'];
                $webhook->handleMessage($cart, $message);
            }
        } elseif (isset($input['entry'][0]['messaging'][0]['postback'])) {
            $payload = $input['entry'][0]['messaging'][0]['postback']['payload'];
            if(isset($input['entry'][0]['messaging'][0]['postback']['referral'])) {
                if(empty($cart)) {
                    $table_id = $input['entry'][0]['messaging'][0]['postback']['referral']['ref'];
                    $newCart = $cartRepo->setCart($psid, $table_id);
                }
                $webhook->handlePostback($newCart, $payload);
            } else {
                if(empty($cart)) {
                    $response = ["text"=>"Veuillez tout d'abord scanner un code messenger... C'est pour mieux vous servir mon enfant!"];
                    $webhook->reply($response, $psid);
                } else {
                    $webhook->handlePostback($cart, $payload);
                }
            }
        } elseif(isset($input['entry'][0]['messaging'][0]['referral'])) {
            if(empty($cart)) {
                $table_id = $input['entry'][0]['messaging'][0]['referral']['ref'];
                $newCart = $cartRepo->setCart($psid, $table_id);
            }
            $response = ["text"=>"Merci d'avoir scanné votre code messenger. Vous pouvez maintenant commander :-)"];
            $webhook->reply($response, $psid);
        }

        return new Response();
    }
}