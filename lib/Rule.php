<?php

declare(strict_types=1);

namespace Rule;

use Card\Card;

class Rule
{
    /**
     * カードの番号ごとの得点
     *
     * @var array<string, int>
     */
    private const CARD_POINTS = [
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

    /**
     * 番号がAでかつ得点が11点となるときの追加点
     */
    private const A_ADD_POINT = 10;

    /**
     * ゲームで勝敗を判定するための点数
     * @var int
     */
    private const POINT = 21;

    /**
     * CARD_POINTSの配列を返却
     *
     * @return array<int|string, int>
     */
    public function getCardPoints(): array
    {
        return self::CARD_POINTS;
    }

    /**
     * 点数を計算する処理
     *
     * @param array<int, Card> $cards
     * @return integer
     */
    public function calcPoint(array $cards): int
    {
        $point = 0;
        $cardACount = 0;

        foreach ($cards as $card) {
            if ($card->cardNumber === 'A') {
                $cardACount++;
            } else {
                $point += self::CARD_POINTS[$card->cardNumber];
            }
        }

        $point += $this->calcCardAPoint($point, $cardACount);

        return $point;
    }

    /**
     * カードAの点数のみを計算する処理
     *
     * @param integer $point
     * @param integer $count
     * @return integer
     */
    public function calcCardAPoint(int $point, int $count): int
    {
        $cardAPoint = 0;
        $i = 0;
        while ($i < $count) {
            if ($point <= 10 && $cardAPoint <= 10) {
                $cardAPoint += self::CARD_POINTS['A'] + self::A_ADD_POINT;
            } else {
                $cardAPoint += self::CARD_POINTS['A'];
            }
            $i++;
        }

        return $cardAPoint;
    }

    public function getPoint(): int
    {
        return self::POINT;
    }
}
