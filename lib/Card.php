<?php

class Card
{
    const SUIT = ['クラブ', 'ダイヤ', 'ハート', 'スペード'];

    const NUMBER = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];


    public function __construct(public string $cardSuit, public string $cardNumber)
    {
    }

    // カードの記号を取得できる
    public static function getSuit(): array
    {
        return self::SUIT;
    }

    // カードの数字を取得できる
    public static function getNumber(): array
    {
        return self::NUMBER;
    }
}
