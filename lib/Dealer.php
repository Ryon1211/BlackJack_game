<?php

declare(strict_types=1);

namespace Dealer;

use CardDeck\CardDeck;
use Role\Role;
use Rule\Rule;

class Dealer extends Role
{
    /**
     * コンストラクタ
     *
     * @param Rule $rule
     * @param CardDeck $cardDeck
     */
    public function __construct(public Rule $rule, public CardDeck $cardDeck)
    {
        parent::__construct($rule, $cardDeck);
    }

    /**
     * ゲーム開始時に複数枚のカードを引く処理
     *
     * @return void
     */
    public function firstDrawCard(): void
    {
        $count = 0;

        while ($count < $this->firstDrawCount) {
            $this->draw();
            $count++;
        }

        $suitNum = $this->getSuitAndNumber(0);
        echo "ディーラーの引いたカードは{$suitNum['suit']}の{$suitNum['number']}です。" . PHP_EOL .
            'ディーラーの引いた２枚めのカードはわかりません。' . PHP_EOL;
    }

    /**
     * ディーラーのターンになったとき、一定の得点以上になるまでカードを引く処理
     *
     * @return void
     */
    public function drawCard(): void
    {
        $this->showSecondCard();
        echo "ディーラーの現在の得点は{$this->getPoint()}です。" . PHP_EOL;

        $count = $this->firstDrawCount;
        while ($this->point < $this->dealerTakePoint) {
            $this->draw();
            $suitNum = $this->getSuitAndNumber($count);
            echo "ディーラーの引いたカードは{$suitNum['suit']}の{$suitNum['number']}でした。" . PHP_EOL;
            $count++;
        }
    }

    /**
     * 2枚目のカードを表示する関数
     *
     * @return void
     */
    public function showSecondCard(): void
    {
        $suitNum = $this->getSuitAndNumber($this->firstDrawCount - 1);
        echo "ディーラーの引いた2枚目のカードは{$suitNum['suit']}の{$suitNum['number']}でした。" . PHP_EOL;
    }
}
