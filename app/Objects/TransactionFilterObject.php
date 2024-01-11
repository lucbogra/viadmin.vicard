<?php

namespace App\Objects;

class TransactionFilterObject extends FilterObject {

    public $type;
    public $method;

    public function __construct()
    {
        $this->type = request()->type;
        $this->method = request()->method;
    }

}