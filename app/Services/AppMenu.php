<?php

namespace App\Services;

use App\Models\CardRequest;
use App\Models\CardTopUpRequest;

class AppMenu {

    public function render(): array {

        return $this->admin();

    }

    public function admin(): array {

        return [

            [
                "block" => __("Dashboard"),
                "items" => [
                    [
                        "name"    => __("Dashboard"), 
                        "url"     => route("dashboard"), 
                        "icon"    => "ant-design:home-outlined",
                        "current" => request()->routeIs('dashboard'), 
                        "subMenu" => [],
                        "badge"   => null
                    ],  

                    [
                        "name"    => __("Customers"), 
                        "url"     => route("customers.index"), 
                        "icon"    => "ci:users-group",
                        "current" => request()->routeIs('customers.*'), 
                        "subMenu" => [],
                        "badge"   => null
                    ], 

                    [
                        "name"    => __("Cards"), 
                        "url"     => route("cards.index"), 
                        "icon"    => "wpf:bank-cards",
                        "current" => request()->routeIs('cards.*'), 
                        "subMenu" => [],
                        "badge"   => null
                    ],    
                ]
            ],

            [
                "block" => __("Requests"),
                "items" => [
                    [
                        "name"    => __("Card Requests"), 
                        "url"     => route("card-requests.index"), 
                        "icon"    => "carbon:intent-request-scale-in",
                        "current" => request()->routeIs('card-requests.*'), 
                        "subMenu" => [],
                        "badge"   => [
                            "type" => "info",
                            "value" => CardRequest::pending()->count()
                        ]
                    ],    
                    [
                        "name"    => __("Topup Requests"), 
                        "url"     => route("topup-requests.index"), 
                        "icon"    => "majesticons:money-plus-line",
                        "current" => request()->routeIs('topup-requests.*'), 
                        "subMenu" => [],
                        "badge"   => [
                            "type" => "info",
                            "value" => CardTopUpRequest::pending()->count()
                        ]
                    ],    
                ]
            ],

            [
                "block" => __("Settings"),
                "items" => [
                    [
                        "name"    => __("Our Banks Info"), 
                        "url"     => route("settings.banks.index"), 
                        "icon"    => "basil:bank-solid",
                        "current" => request()->routeIs('settings.banks.*'), 
                        "subMenu" => [],
                        "badge"   => null
                    ],    
      
                ]
            ],
       

        ];

    }

    public function quickLinks(): array {

        return [

            // [
            //     "name"    => __("Products"),
            //     "url"     => route("products.index"),
            //     "icon"    => "CircleStackIcon",
            //     "current" => false,
            // ],

        ];

    }

}
