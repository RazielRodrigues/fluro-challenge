<?php

class MultipricedPromotion
{
    public $count;
    public $price;

    public function __construct($count, $price)
    {
        $this->count = $count;
        $this->price = $price;
    }
}
