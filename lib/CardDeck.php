<?php

declare(strict_types=1);

namespace CardDeck;

use Card\Card;

class CardDeck
{
    /**
     * コンストラクタで作成されたカードインスタンスのリスト
     *
     * @var array<int, Card>
     */
    public array $cards;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        // Cardクラスから記号と数字を取得して、カードデッキを生成
        $suits = Card::getSuit();
        $numberAndPoints = Card::getNumber();

        foreach ($suits as $suit) {
            foreach ($numberAndPoints as $number) {
                $this->cards[] = new Card($suit, $number);
            }
        }
    }

    /**
     * $this->cardsから１枚のカードをランダムに引く
     *
     * @return Card
     */
    public function drawCard(): Card
    {
        return array_splice($this->cards, mt_rand(0, count($this->cards) - 1), 1)[0];
    }
}
