<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Card\Card;
use Rule\Rule;

require_once(__DIR__ . '/../lib/Card.php');
require_once(__DIR__ . '/../lib/Rule.php');

final class RuleTest extends TestCase
{
    public function testGetCardPoints(): void
    {
        $cardDeck = new Rule();
        $this->assertSame([
            'A' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '10' => 10,
            'J' => 10,
            'Q' => 10,
            'K' => 10
        ], $cardDeck->getCardPoints());
    }

    public function testCalcPoint(): void
    {
        $rule = new Rule();
        $cards1 = [
            new Card(Card::getSuit()[0], Card::getNumber()[0]),
            new Card(Card::getSuit()[1], Card::getNumber()[0]),
        ];
        $cards2 = [
            new Card(Card::getSuit()[0], Card::getNumber()[0]),
            new Card(Card::getSuit()[1], Card::getNumber()[12]),
        ];
        $cards3 = [
            new Card(Card::getSuit()[0], Card::getNumber()[1]),
            new Card(Card::getSuit()[1], Card::getNumber()[12]),
        ];
        $cards4 = [
            new Card(Card::getSuit()[0], Card::getNumber()[0]),
            new Card(Card::getSuit()[1], Card::getNumber()[0]),
            new Card(Card::getSuit()[2], Card::getNumber()[0]),
        ];
        $cards5 = [
            new Card(Card::getSuit()[0], Card::getNumber()[1]),
            new Card(Card::getSuit()[1], Card::getNumber()[0]),
            new Card(Card::getSuit()[2], Card::getNumber()[1]),
        ];
        $this->assertSame(12, $rule->calcPoint($cards1));
        $this->assertSame(21, $rule->calcPoint($cards2));
        $this->assertSame(12, $rule->calcPoint($cards3));
        $this->assertSame(13, $rule->calcPoint($cards4));
        $this->assertSame(15, $rule->calcPoint($cards5));
    }
}
