<?php

namespace AppBundle\Service;

class Template
{
    public function welcomeMessage()
    {
        $response = [
            "attachment"=>[
                "type"=>"template",
                "payload"=>[
                    "template_type"=>"generic",
                    "elements"=>[
                        [
                            "title"=>"Bonjour! Souhaitez vous consulter notre carte ?",
                            "subtitle"=>"Choisissez parmis nos bières, vins, cocktails, apéritifs...",
                            "buttons"=>[
                                [
                                    "type"=>"postback",
                                    "title"=>"Oui !",
                                    "payload"=>"YesShowMeTheMenu",
                                ],
                                [
                                    "type"=>"postback",
                                    "title"=>"Pas pour le moment",
                                    "payload"=>"DontShowMeTheMenu",
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    
        return $response;
    }

    public function defaultResponse()
    {
        $response = ["text"=>"Je ne sais pas encore dire beaucoup de choses en revanche, je peux vous montrer la carte si vous envoyez 'carte'. Merci et à votre santé!"];
    
        return $response;	
    }

    public function showMenu($data, $location)
    {
        switch($location) {
            case "first_menu":
                $payload = "second_menu";
                break;
            case "second_menu":
                $payload = "third_menu";
                break;
            case "third_menu":
                $payload = "fourth_menu";
                break;
            case "fourth_menu":
                $payload = "fifth_menu";
                break;
            default:
                $payload = "first_menu";
        }
        $response = [
            "attachment"=>[
                "type"=>"template",
                "payload"=>[
                    "template_type"=>"list",
                    "top_element_style"=>"compact",
                    "elements"=>[
                        [
                            "title"=>$data[0]['title'],
                            "subtitle"=>$data[0]['subtitle'],
                            "buttons"=>[
                                [
                                    "title"=>"Voir les ".mb_strtolower($data[0]['title'], 'UTF-8'),
                                    "type"=>"postback",
                                    "payload"=>$data[0]['payload'],
                                ]
                            ]
                        ],
                        [
                            "title"=>$data[1]['title'],
                            "subtitle"=>$data[1]['subtitle'],
                            "buttons"=>[
                                [
                                    "title"=>"Voir les ".mb_strtolower($data[1]['title'], 'UTF-8'),
                                    "type"=>"postback",
                                    "payload"=>$data[1]['payload'],
                                ]
                            ]
                        ],
                        [
                            "title"=>$data[2]['title'],
                            "subtitle"=>$data[2]['subtitle'],
                            "buttons"=>[
                                [
                                    "title"=>"Voir les ".mb_strtolower($data[2]['title'], 'UTF-8'),
                                    "type"=>"postback",
                                    "payload"=>$data[2]['payload'],
                                ]
                            ]
                        ],
                        [
                            "title"=>$data[3]['title'],
                            "subtitle"=>$data[3]['subtitle'],
                            "buttons"=>[
                                [
                                    "title"=>"Voir les ".mb_strtolower($data[3]['title'], 'UTF-8'),
                                    "type"=>"postback",
                                    "payload"=>$data[3]['payload'],
                                ]
                            ]
                        ]
                    ],
                    "buttons"=>[
                        [
                            "title"=>"Voir plus",
                            "type"=>"postback",
                            "payload"=>$payload,
                        ]
                    ]
                ]
            ]
        ];
    
        return $response;
    }

    public function dontShowMenu()
    {
        $response = ["text"=>"Pas de problème. Tappez 'carte' à tout moment pour afficher notre carte :-)"];
    
        return $response;
    }

    public function showProducts($data, $location, $payload)
    {
        switch($location) {
            case "first_page:".$payload:
                $showMore = "second_page:".$payload;
                break;
            case "second_page:".$payload:
                $showMore = "third_page:".$payload;
                break;
            case "third_page:".$payload:
                $showMore = "fourth_page:".$payload;
                break;
            case "fourth_page:".$payload:
                $showMore = "fifth_page:".$payload;
                break;
            default:
                $showMore = "first_page:".$payload;
        }
    
        $response = [
            "attachment"=>[
                "type"=>"template",
                "payload"=>[
                    "template_type"=>"list",
                    "top_element_style"=>"compact",
                    "elements"=>[
                        [
                            "title"=>$data[0]['title'],
                            "subtitle"=>$data[0]['subtitle'],
                            "buttons"=>[
                                [
                                    "title"=>"Commander - ".number_format(floatval($data[0]['price']), 2)."€",
                                    "type"=>"postback",
                                    "payload"=>$data[0]['payload'],
                                ]
                            ]
                        ],
                        [
                            "title"=>$data[1]['title'],
                            "subtitle"=>$data[1]['subtitle'],
                            "buttons"=>[
                                [
                                    "title"=>"Commander - ".number_format(floatval($data[1]['price']), 2)."€",
                                    "type"=>"postback",
                                    "payload"=>$data[1]['payload'],
                                ]
                            ]
                        ],
                        [
                            "title"=>$data[2]['title'],
                            "subtitle"=>$data[2]['subtitle'],
                            "buttons"=>[
                                [
                                    "title"=>"Commander - ".number_format(floatval($data[2]['price']), 2)."€",
                                    "type"=>"postback",
                                    "payload"=>$data[2]['payload'],
                                ]
                            ]
                        ],
                        [
                            "title"=>$data[3]['title'],
                            "subtitle"=>$data[3]['subtitle'],
                            "buttons"=>[
                                [
                                    "title"=>"Commander - ".number_format(floatval($data[3]['price']), 2)."€",
                                    "type"=>"postback",
                                    "payload"=>$data[3]['payload'],
                                ]
                            ]
                        ],
                    ],
                    "buttons"=>[
                        [
                            "title"=>"Voir plus",
                            "type"=>"postback",
                            "payload"=>$showMore,
                        ]
                    ]
                ]
            ]
        ];
    
        return $response;
    }

    public function anotherDrink($cart)
    {
        $url = "https://www.orderhero.fr/pay/".$cart->getId();
        $response = [
            "attachment"=>[
                "type"=>"template",
                "payload"=> [
                    "template_type"=>"generic",
                    "elements"=> [
                        [
                            "title"=>"Commande enregistrée !",
                            "subtitle"=>"Désirez-vous autre chose ?",
                            "buttons"=> [
                                [
                                    "type"=>"postback",
                                    "title"=>"Oui !",
                                    "payload"=>"anotherDrink",
                                ],
                                [
                                    "type"=>"web_url",
                                    "url"=>$url,
                                    "webview_height_ratio"=>"compact",
                                    "title"=>"Procéder au paiement",
                                    "messenger_extensions"=>true,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    
        return $response;
    }

    public function payOrder($cart)
    {
        $url = "https://www.orderhero.fr/pay/".$cart->getId();
        $response = [
            "attachment"=>[
                "type"=>"template",
                "payload"=> [
                    "template_type"=>"generic",
                    "elements"=> [
                        [
                            "title"=>"Paiement de votre commande",
                            "buttons"=> [
                                [
                                    "type"=>"web_url",
                                    "url"=>$url,
                                    "webview_height_ratio"=>"compact",
                                    "title"=>"Procéder au paiement",
                                    "messenger_extensions"=>true,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    
        return $response;
    }
}