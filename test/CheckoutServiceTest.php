<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '../../src/entities/BuyNGetOneFreePromotion.php';
require_once __DIR__ . '../../src/entities/Item.php';
require_once __DIR__ . '../../src/entities/MealDealPromotion.php';
require_once __DIR__ . '../../src/entities/MultipricedPromotion.php';
require_once __DIR__ . '../../src/entities/PricingRule.php';
require_once __DIR__ . '../../src/CheckoutService.php';

class CheckoutServiceTest extends TestCase
{
    private $itemA, $itemB, $itemC, $itemD, $itemE, $pricingRules;

    protected function setUp(): void
    {
        // Define items
        $this->itemA = new Item('A', 50);
        $this->itemB = new Item('B', 75);
        $this->itemC = new Item('C', 25);
        $this->itemD = new Item('D', 150);
        $this->itemE = new Item('E', 200);

        // Define pricing rules
        $this->pricingRules = [
            new PricingRule($this->itemA),
            new PricingRule($this->itemB, new MultipricedPromotion(2, 125)),
            new PricingRule($this->itemC, new BuyNGetOneFreePromotion(3)),
            new PricingRule($this->itemD),
            new PricingRule($this->itemE),
            new PricingRule($this->itemD, new MealDealPromotion([$this->itemD, $this->itemE], 300))
        ];
    }

    public function testNoItems()
    {
        $checkout = new CheckoutService($this->pricingRules);
        $this->assertEquals(0, $checkout->total());
    }

    public function testSingleItem()
    {
        $checkout = new CheckoutService($this->pricingRules);
        $checkout->scan('A');
        $this->assertEquals(50, $checkout->total());
    }

    public function testMultipleItemsNoPromotion()
    {
        $checkout = new CheckoutService($this->pricingRules);
        $checkout->scan('A');
        $checkout->scan('B');
        $checkout->scan('C');
        $this->assertEquals(150, $checkout->total());
    }

    public function testMultipricedPromotion()
    {
        $checkout = new CheckoutService($this->pricingRules);
        $checkout->scan('B');
        $checkout->scan('B');
        $this->assertEquals(125, $checkout->total());
    }

    public function testBuyNGetOneFreePromotion()
    {
        $checkout = new CheckoutService($this->pricingRules);
        $checkout->scan('C');
        $checkout->scan('C');
        $checkout->scan('C');
        $checkout->scan('C');
        $this->assertEquals(75, $checkout->total());
    }

    public function testMealDealPromotion()
    {
        $checkout = new CheckoutService($this->pricingRules);
        $checkout->scan('D');
        $checkout->scan('E');
        $this->assertEquals(300, $checkout->total());
    }

    public function testMixedPromotions()
    {
        $checkout = new CheckoutService($this->pricingRules);
        $checkout->scan('A');
        $checkout->scan('B');
        $checkout->scan('B');
        $checkout->scan('C');
        $checkout->scan('C');
        $checkout->scan('C');
        $checkout->scan('C');
        $checkout->scan('D');
        $checkout->scan('E');
        $this->assertEquals(550, $checkout->total());
    }
}
