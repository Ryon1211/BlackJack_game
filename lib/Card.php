<?php

declare(strict_types=1);

namespace Card;

class Card
{
    /**
     * カードのスート
     *
     * @var string[]
     */
    private const SUIT = ['クラブ', 'ダイヤ', 'ハート', 'スペード'];

    /**
     * カードの番号
     *
     * @var string[]
     */
    private const NUMBER = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

    /**
     * コンストラクタ
     *
     * @param string $cardSuit
     * @param string $cardNumber
     */
    public function __construct(public string $cardSuit, public string $cardNumber)
    {
    }

    /**
     * カードの記号を取得できる
     *
     * @return array<int, string>
     */
    public static function getSuit(): array
    {
        return self::SUIT;
    }

    /**
     * カードの数字を取得できる
     *
     * @return array<int, string>
     */
    public static function getNumber(): array
    {
        return self::NUMBER;
    }
}
