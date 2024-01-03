<?php

namespace App\Objects;

class FilterObject {

    public $perPage;
    public $sort;
    public $order;
    public $term;
    public $filter;
    public $status;
    public $filtred;

    public function __construct()
    {
        $this->perPage = request()->per_page;
        $this->sort = request()->sort;
        $this->order = request()->order;
        $this->filter = request()->filter;
        $this->status = request()->status;
        $this->term = (request()->search ?? null);

        if (request()->search || request()->status || request()->filter) {
            $this->filtred = true;
        } else {
            $this->filtred = false;
        }
    }

}