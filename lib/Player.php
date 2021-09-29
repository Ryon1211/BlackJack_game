<?php

declare(strict_types=1);

namespace Player;

use CardDeck\CardDeck;
use Role\Role;
use Rule\Rule;

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

        while ($count < $this->firstDrawCount) {
            $this->draw();
            $suitNum = $this->getSuitAndNumber($count);
            echo "あなたの引いたカードは{$suitNum['suit']}の{$suitNum['number']}です。" . PHP_EOL;
            $count++;
        }
    }

    /**
     * プレイヤーのターンに、プレイヤーがカードを引く処理
     *
     * @return void
     */
    public function drawCard(): void
    {
        // プレイヤーの得点の合計を表示
        echo "あなたの現在の得点は{$this->getPoint()}です。";
        $count = $this->firstDrawCount;
        // プレイヤーのカードの合計値が21を超えたらプレイヤーの負け
        while ($this->getPoint() < $this->rule->getPoint()) {
            // プレイヤーにカードを引くか確認する
            echo "カードを引きますか？（Y/N）" . PHP_EOL;
            $stdin = trim(fgets(STDIN));

            // 引く
            if ($stdin === 'Y') {
                $this->draw();
                $suitNum = $this->getSuitAndNumber($count);
                echo "あなたの引いたカードは{$suitNum['suit']}の{$suitNum['number']}です。" . PHP_EOL;
                $count++;
            }

            // 引かない
            if ($stdin === 'N' || $this->rule->getPoint() <= $this->point) {
                break;
            }
        }
    }
}
