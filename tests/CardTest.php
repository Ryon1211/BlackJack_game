<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Card\Card;

final class CardTest extends TestCase
{
    public function testGetSuit(): void
    {
        $this->assertSame(['クラブ', 'ダイヤ', 'ハート', 'スペード'], Card::getSuit());
    }

    public function testGetNumber(): void
    {
        $this->assertSame(
            ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'],
            Card::getNumber()
        );
    }
}
