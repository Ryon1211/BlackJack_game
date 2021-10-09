<?php

declare(strict_types=1);

namespace Dealer;

use CardDeck\CardDeck;
use Role\Role;
use Rule\Rule;
use Utility\Utility;

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

        while ($count < $this->rule->getFirstDrawCard()) {
            $this->draw();
            $count++;
        }

        $suitNum = $this->getSuitAndNumber(0);
        Utility::showMsg("ディーラーの引いたカードは{$suitNum['suit']}の{$suitNum['number']}です。");
        Utility::showMsg('ディーラーの引いた２枚めのカードはわかりません。');
    }

    /**
     * ディーラーのターンになったとき、一定の得点以上になるまでカードを引く処理
     *
     * @return bool
     */
    public function drawCard(): bool
    {
        Utility::showMsg('ディーラーの引いた２枚めのカードはわかりません。');
        Utility::showMsg("ディーラーの現在の得点は{$this->getPoint()}です。");
        $count = count($this->cards);
        if ($this->point < $this->rule->getDealerTakeScore()) {
            $this->draw();
            $suitNum = $this->getSuitAndNumber($count);
            Utility::showMsg("ディーラーの引いたカードは{$suitNum['suit']}の{$suitNum['number']}でした。");
            return true;
        }

        return false;
    }

    /**
     * 2枚目のカードを表示する関数
     *
     * @return void
     */
    public function showSecondCard(): void
    {
        $suitNum = $this->getSuitAndNumber($this->rule->getFirstDrawCard() - 1);
        Utility::showMsg("ディーラーの引いた2枚目のカードは{$suitNum['suit']}の{$suitNum['number']}でした。");
    }
}
