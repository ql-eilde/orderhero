<?php

namespace AppBundle\Service;

use AppBundle\Service\Template;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Webhook
{
    private $template;
    private $container;

    public function __construct(Template $template, ContainerInterface $container)
    {
        $this->template = $template;
        $this->container = $container;
    }

    public function reply($response, $sender)
    {
        $message = [
            "messaging_type"=>"RESPONSE",
            "recipient"=>[
                "id"=>$sender
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

    public function handleMessage($sender, $message)
    {
        $response = "";
        switch(strtolower($message)) {
            case 'carte':
                $response = $this->template->showMenu();
                break;
            default:
                $response = $this->template->defaultResponse();
        }

        $this->reply($response, $sender);
    }

    public function handlePostback($sender, $payload)
    {
        $response = ["text"=>"ok bien recu"];
        $this->reply($response, $sender);
    }
}