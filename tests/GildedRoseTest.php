<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);

        $this->assertSame(-1, $items[0]->sellIn); // Verwacht dat sellIn met 1 is afgenomen
        $this->assertSame(0, $items[0]->quality); // Verwacht dat de kwaliteit op 0 blijft (niet negatief)
    }
}
