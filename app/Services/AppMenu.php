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
                        "name"    => __("Statistics"), 
                        "url"     => route("dashboard"), 
                        "icon"    => "akar-icons:statistic-up",
                        "current" => request()->routeIs('dashboard'), 
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
                        "current" => request()->routeIs('dashboard'), 
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
