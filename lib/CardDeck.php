<?php
require('Card.php');

class CardDeck
{
    public array $cards;

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

    // 生成したカードデッキから、１枚のカードをランダムに引く
    public function drawCard(): Card
    {
        return array_splice($this->cards, mt_rand(0, count($this->cards) - 1), 1)[0];
    }
}
