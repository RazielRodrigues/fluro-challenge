<?php

require_once __DIR__ . '/entities/BuyNGetOneFreePromotion.php';
require_once __DIR__ . '/entities/Item.php';
require_once __DIR__ . '/entities/MealDealPromotion.php';
require_once __DIR__ . '/entities/MultipricedPromotion.php';
require_once __DIR__ . '/entities/PricingRule.php';

class Checkout
{
    private $pricingRules;
    private $scannedItems;

    public function __construct($pricingRules)
    {
        $this->pricingRules = $pricingRules;
        $this->scannedItems = [];
    }

    public function scan($itemSku)
    {
        if (!isset($this->scannedItems[$itemSku])) {
            $this->scannedItems[$itemSku] = 0;
        }
        $this->scannedItems[$itemSku]++;
    }

    public function total()
    {
        $total = 0;
        $itemsToRemove = [];

        foreach ($this->pricingRules as $rule) {
            if ($rule->promotion instanceof MealDealPromotion) {
                while ($this->allItemsAvailable($rule->promotion->items)) {
                    $total += $rule->promotion->price;
                    foreach ($rule->promotion->items as $item) {
                        $this->scannedItems[$item->sku]--;
                        if ($this->scannedItems[$item->sku] == 0) {
                            $itemsToRemove[] = $item->sku;
                        }
                    }
                }
            }
        }

        foreach ($this->pricingRules as $rule) {
            if (in_array($rule->item->sku, $itemsToRemove)) {
                continue;
            }
            $count = $this->scannedItems[$rule->item->sku] ?? 0;
            if ($rule->promotion instanceof MultipricedPromotion) {
                $total += intdiv($count, $rule->promotion->count) * $rule->promotion->price;
                $total += ($count % $rule->promotion->count) * $rule->item->unitPrice;
            } elseif ($rule->promotion instanceof BuyNGetOneFreePromotion) {
                $total += (intdiv($count, $rule->promotion->n + 1) * $rule->promotion->n + ($count % ($rule->promotion->n + 1))) * $rule->item->unitPrice;
            } else {
                $total += $count * $rule->item->unitPrice;
            }
        }

        return $total;
    }

    private function allItemsAvailable($items)
    {
        foreach ($items as $item) {
            if (($this->scannedItems[$item->sku] ?? 0) <= 0) {
                return false;
            }
        }
        return true;
    }
}
