<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose // Final class to prevent inheritance
{
    /**
     * @param Item[] $items
     */
    public function __construct($items)
    {
        $this->items = $items; // Items to update
    }

    public function updateQuality()
    {
        foreach ($this->items as $item) {
            switch ($item->name) {
                case 'Aged Brie':
                    $this->updateAgedBrie($item); // "Aged Brie" increases in quality as it ages
                    break;

                case 'Backstage passes to a TAFKAL80ETC concert':
                    $this->updateBackstagePasses($item); // "Backstage passes" increase in quality as the concert approaches
                    break;

                case 'Sulfuras, Hand of Ragnaros':
                    // "Sulfuras" does not change in quality or sellIn, so skip it.
                    break;

                default:
                    if (strpos($item->name, 'Conjured') !== false) {
                        $this->updateConjuredItem($item); //Conjured items degrade in Quality twice as fast as normal items
                    } else {
                        $this->updateRegularItem($item);
                    }
                    break;
            }
        }
    }

    private function updateAgedBrie($item)
    {
        if ($item->quality < 50) {
            $item->quality++; // Quality increases by 1
        }
    }

    private function updateBackstagePasses($item)
    {
        if ($item->sellIn < 0) {
            $item->quality = 0; // Quality drops to 0 after the concert
        } else {
            if ($item->quality < 50) {
                $item->quality++;
                if ($item->sellIn < 10 && $item->quality < 50) {
                    $item->quality++;
                    $item->quality++; // Quality increases by 2 when there are 10 days or less
                }
                if ($item->sellIn < 5 && $item->quality < 50) {
                    $item->quality++; // Quality increases by 3 when there are 5 days or less
                }
            }
        }
    }

    private function updateConjuredItem($item)
    {
        $degradeRate = ($item->sellIn < 0) ? 4 : 2; // Degrades twice as fast, faster after the sell date
        $item->quality = max(0, $item->quality - $degradeRate);
        $item->sellIn--;
    }

    private function updateRegularItem($item)
    {
        $degradeRate = ($item->sellIn < 0) ? 2 : 1; // Degrades, faster after the sell date
        $item->quality = max(0, $item->quality - $degradeRate);
        $item->sellIn--;
    }
}



