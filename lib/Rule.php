<?php

class Rule
{
    const CARD_POINTS = [
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
    ];

    const PLAYER_POINT = 21;

    const DEALER_POINT = 17;

    public function getCardPoints(): array
    {
        return self::CARD_POINTS;
    }
}
