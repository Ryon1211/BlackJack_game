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
    private const WINNING_SCORE = 21;

    /**
     * ディーラーは以下の点数までカードを引き続ける
     *
     * @var int
     */
    private const DEALER_TAKE_SCORE = 17;

    /**
     * 最初のターンで引くカードの枚数
     *
     * @var int
     */
    private const FIRST_DRAW_CARD = 2;


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
     * @param integer $cardCount
     * @return integer
     */
    public function calcCardAPoint(int $point, int $cardCount): int
    {
        $cardAPoint = 0;
        $count = 0;
        while ($count < $cardCount) {
            if ($point <= 10 && $cardAPoint <= 10) {
                $cardAPoint += self::CARD_POINTS['A'] + self::A_ADD_POINT;
            } else {
                $cardAPoint += self::CARD_POINTS['A'];
            }
            $count++;
        }

        return $cardAPoint;
    }

    /**
     * ゲームの勝敗得点を返却
     *
     * @return integer
     */
    public function getWinningScore(): int
    {
        return self::WINNING_SCORE;
    }

    /**
     * ディーラーがカードを引き続ける得点を返却
     *
     * @return integer
     */
    public function getDealerTakeScore(): int
    {
        return self::DEALER_TAKE_SCORE;
    }

    /**
     * １順目に引くカードの枚数
     *
     * @return integer
     */
    public function getFirstDrawCard(): int
    {
        return self::FIRST_DRAW_CARD;
    }
}
