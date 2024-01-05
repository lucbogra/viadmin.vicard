<?php

namespace App\Services;

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
                        "subMenu" => []
                    ],  

                    [
                        "name"    => __("Customers"), 
                        "url"     => route("customers.index"), 
                        "icon"    => "ci:users-group",
                        "current" => request()->routeIs('customers.*'), 
                        "subMenu" => []
                    ], 

                    [
                        "name"    => __("Cards"), 
                        "url"     => route("dashboard"), 
                        "icon"    => "ion:card-outline",
                        "current" => request()->routeIs('cards.*'), 
                        "subMenu" => []
                    ],    
                ]
            ],

            [
                "block" => __("Requests"),
                "items" => [
                    [
                        "name"    => __("Card Requests"), 
                        "url"     => route("dashboard"), 
                        "icon"    => "carbon:intent-request-scale-in",
                        "current" => request()->routeIs('card-requests.*'), 
                        "subMenu" => []
                    ],    
                    [
                        "name"    => __("Topup Requests"), 
                        "url"     => route("topup-requests.index"), 
                        "icon"    => "majesticons:money-plus-line",
                        "current" => request()->routeIs('topup-requests.*'), 
                        "subMenu" => []
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
                        "subMenu" => []
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
