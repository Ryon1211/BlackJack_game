<?php

declare(strict_types=1);

namespace CpuPlayer;

use CardDeck\CardDeck;
use Role\Role;
use Rule\Rule;
use Utility\Utility;

class CpuPlayer extends Role
{
    /**
     * コンストラクタ
     *
     * @param Rule $rule
     * @param CardDeck $cardDeck
     * @param string $name
     */
    public function __construct(public Rule $rule, public CardDeck $cardDeck, private string $name)
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
            Utility::showMsg("{$this->getPlayerName()}の引いたカードは{$suitNum['suit']}の{$suitNum['number']}です。");
            $count++;
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
            Utility::showMsg("{$this->getPlayerName()}の現在の得点は{$this->getPoint()}です。");

            // プレイヤーがカードを引く選択は得点に応じて確率を変更する
            // 10点以下であれば、必ず引く
            $drawFlg = 0;
            // 17点より多ければ、2分の1にする
            if (17 < $this->getPoint()) {
                $drawFlg = rand(0, 1);
            }

            // カードを引く
            if ($drawFlg === 0 && $this->point <= $this->rule->getWinningScore()) {
                $this->draw();
                $count = count($this->cards) - 1;
                $suitNum = $this->getSuitAndNumber($count);
                Utility::showMsg("{$this->getPlayerName()}の引いたカードは{$suitNum['suit']}の{$suitNum['number']}です。");
                return true;
            }
        }
        return false;
    }

    /**
     * $nameを返却
     *
     * @return string
     */
    public function getPlayerName(): string
    {
        return $this->name;
    }
}
