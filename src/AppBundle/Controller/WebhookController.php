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

        $cartRepo = $this->getDoctrine()->getRepository('AppBundle:BarCart');

        $input = json_decode(file_get_contents('php://input'), true);

        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
        $userHasCart = $cartRepo->userHasCart($sender);
        $response = ["text"=>"Bonjour !"];
        $webhook->reply($response, $sender);

        return new Response();
    }
}