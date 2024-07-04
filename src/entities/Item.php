<?php

class Item
{
    public $sku;
    public $unitPrice;

    public function __construct($sku, $unitPrice)
    {
        $this->sku = $sku;
        $this->unitPrice = $unitPrice;
    }
}
