<?php

class PricingRule
{
    public $item;
    public $promotion;

    public function __construct($item, $promotion = null)
    {
        $this->item = $item;
        $this->promotion = $promotion;
    }
}
