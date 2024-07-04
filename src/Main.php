<?php

require_once __DIR__ . '/entities/BuyNGetOneFreePromotion.php';
require_once __DIR__ . '/entities/Item.php';
require_once __DIR__ . '/entities/MealDealPromotion.php';
require_once __DIR__ . '/entities/MultipricedPromotion.php';
require_once __DIR__ . '/entities/PricingRule.php';
require_once __DIR__ . '/Checkout.php';

function main()
{
    $itemA = new Item('A', 50);
    $itemB = new Item('B', 75);
    $itemC = new Item('C', 25);
    $itemD = new Item('D', 150);
    $itemE = new Item('E', 200);

    $pricingRules = [
        new PricingRule($itemA),
        new PricingRule($itemB, new MultipricedPromotion(2, 125)),
        new PricingRule($itemC, new BuyNGetOneFreePromotion(3)),
        new PricingRule($itemD),
        new PricingRule($itemE),
        new PricingRule($itemD, new MealDealPromotion([$itemD, $itemE], 300))
    ];

    $checkout = new Checkout($pricingRules);

    $checkout->scan('A');
    $checkout->scan('B');
    $checkout->scan('B');
    $checkout->scan('C');
    $checkout->scan('C');
    $checkout->scan('C');
    $checkout->scan('C');
    $checkout->scan('D');
    $checkout->scan('E');

    echo "Total: " . $checkout->total() . " pence\n";
}

main();
