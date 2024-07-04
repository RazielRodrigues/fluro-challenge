<?php

class MealDealPromotion
{
    public $items;
    public $price;

    public function __construct($items, $price)
    {
        $this->items = $items;
        $this->price = $price;
    }
}
