<?php

class Dealer
{
    const INIT_DRAW_NUMBER = 2;
    const DEALER_TAKE_POINT = 17;

    private array $cards;
    private int $point = 0;

    public function __construct(public Rule $rule, public CardDeck $cardDeck)
    {
    }

    public function initDrawCard(): void
    {
        $count = 0;

        while ($count < self::INIT_DRAW_NUMBER) {
            $this->draw();
            $count++;
        }

        $suit_num = $this->getSuitAndNumber(0);
        echo "ディーラーの引いたカードは{$suit_num['suit']}の{$suit_num['number']}です。" . PHP_EOL .
            'ディーラーの引いた２枚めのカードはわかりません。' . PHP_EOL;
    }

    public function drawCard()
    {
        $count = self::INIT_DRAW_NUMBER;

        $suit_num = $this->getSuitAndNumber(self::INIT_DRAW_NUMBER - 1);
        echo "ディーラーの引いた2枚目のカードは{$suit_num['suit']}の{$suit_num['number']}でした。" . PHP_EOL;
        echo "ディーラーの現在の得点は{$this->getPoint()}です。" . PHP_EOL;

        while (true) {
            // ディーラーの得点が17点を超えていない場合
            $this->draw();
            // →ディーラーの引いた一つ前に引いたカードを表示
            $suit_num = $this->getSuitAndNumber($count);
            echo "ディーラーの引いたカードは{$suit_num['suit']}の{$suit_num['number']}でした。" . PHP_EOL;

            if (self::DEALER_TAKE_POINT <= $this->point) {
                break;
            }
        }
    }

    public function draw(): void
    {
        // →ディーラーがカードを引く
        $card = $this->drawCardsFromDeck();
        $this->cards[] = $card;
        $this->setPoint($card);
    }

    public function drawCardsFromDeck(): Card
    {
        return $this->cardDeck->drawCard();
    }

    public function getPoint(): int
    {
        return $this->point;
    }

    private function setPoint(Card $card): void
    {
        $this->point += $this->rule->getCardPoints()[$card->cardNumber];
    }

    public function getSuitAndNumber(int $num): array
    {
        return [
            'suit' => $this->cards[$num]->cardSuit,
            'number' => $this->cards[$num]->cardNumber
        ];
    }
}
