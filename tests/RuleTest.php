<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

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
}
