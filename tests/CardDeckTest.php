<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/CardDeck.php');

final class CardDeckTest extends TestCase
{
    public function testDraw(): void
    {
        $cardDeck = new CardDeck();
        $card = $cardDeck->drawCard();
        $this->assertInstanceOf(Card::class, $card);
        $this->assertNotContains($card, $cardDeck->cards);
    }
}
