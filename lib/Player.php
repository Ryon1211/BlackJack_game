<?php

require_once('CardDeck.php');

class Player
{
    const INIT_DRAW_NUMBER = 2;

    private array $cards;
    private int $point = 0;

    public function __construct(public Rule $rule, public CardDeck $cardDeck)
    {
    }

    // プレイヤーがカードを２枚引く
    public function initDrawCard(): void
    {
        $count = 0;

        while ($count < self::INIT_DRAW_NUMBER) {
            $this->draw();
            $suit_num = $this->getSuitAndNumber($count);
            echo "あなたの引いたカードは{$suit_num['suit']}の{$suit_num['number']}です。" . PHP_EOL;
            $count++;
        }
    }

    public function drawCard(): void
    {
        $count = self::INIT_DRAW_NUMBER;
        // プレイヤーの得点の合計を表示
        // プレイヤーにカードを引くか確認する
        while (true) {
            echo "あなたの現在の得点は{$this->getPoint()}です。カードを引きますか？（Y/N）" . PHP_EOL;
            $stdin = trim(fgets(STDIN));

            // 引いた場合
            if ($stdin === 'Y') {
                $this->draw();
                $suit_num = $this->getSuitAndNumber($count);
                echo "あなたの引いたカードは{$suit_num['suit']}の{$suit_num['number']}です。" . PHP_EOL;
                $count++;
            }

            if ($stdin === 'N' || 21 <= $this->point) {
                break;
            }
        }
    }

    public function draw(): void
    {
        // カードを引く
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
