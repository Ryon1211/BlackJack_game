<?php

declare(strict_types=1);

namespace Player;

use CardDeck\CardDeck;
use Role\Role;
use Rule\Rule;
use Utility\Utility;

class Player extends Role
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
            $suitNum = $this->getSuitAndNumber($count);
            $count++;
            Utility::showMsg("あなたの引いたカードは{$suitNum['suit']}の{$suitNum['number']}です。");
        }
    }

    /**
     * プレイヤーのターンに、プレイヤーがカードを引く処理
     *
     * @return bool
     */
    public function drawCard(): bool
    {
        if ($this->getPoint() < $this->rule->getWinningScore()) {
            Utility::showMsg("あなたの現在の得点は{$this->getPoint()}です。カードを引きますか？（Y/N）");
            $stdin = Utility::getStdin();

            if ($stdin === 'Y' && $this->point <= $this->rule->getWinningScore()) {
                $this->draw();
                $count = count($this->cards) - 1;
                $suitNum = $this->getSuitAndNumber($count);
                Utility::showMsg("あなたの引いたカードは{$suitNum['suit']}の{$suitNum['number']}です。");
                return true;
            }
        }
        return false;
    }
}
