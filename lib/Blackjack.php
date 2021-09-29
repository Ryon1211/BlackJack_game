<?php

declare(strict_types=1);

namespace BlackJack;

use CardDeck\CardDeck;
use Dealer\Dealer;
use Player\Player;
use Rule\Rule;

class BlackJack
{
    private Rule $rule;
    private CardDeck $cardDeck;
    private Player $player;
    private Dealer $dealer;

    /**
     * コンストラクタ
     *
     * ゲーム開始時に関連クラスのインスタンスを生成
     */
    public function __construct()
    {
        // ルールのインスタンスを作成する
        $this->rule = new Rule();
        // カードデッキのインスタンスを作成する
        $this->cardDeck = new CardDeck();
        // プレイヤーのインスタンスを作成する
        $this->player = new Player($this->rule, $this->cardDeck);
        // ディーラーのインスタンスを作成する
        $this->dealer = new Dealer($this->rule, $this->cardDeck);
    }

    /**
     * ゲームの進行処理をする関数
     *
     * @return void
     */
    public function start(): void
    {
        echo 'ブラックジャックを開始します。' . PHP_EOL;
        // プレイヤー、ディーラーがそれぞれカードデッキからカードを引く
        $this->player->firstDrawCard();
        $this->dealer->firstDrawCard();

        // プレイヤーの得点が21点より低いとき
        if ($this->player->getPoint() < $this->rule->getPoint()) {
            $this->player->drawCard();
            $this->dealer->drawCard();
        } else {
            $this->dealer->showSecondCard();
        }

        // 勝敗を判定する
        $this->judgeWinner();

        echo 'ブラックジャックを終了します。' . PHP_EOL;
    }

    /**
     * 勝者の判定を行う関数
     *
     * @return void
     */
    public function judgeWinner(): void
    {
        $playerPoint = $this->player->getPoint();
        $dealerPoint = $this->dealer->getPoint();

        echo "あなたの得点は{$playerPoint}です。" . PHP_EOL;
        echo "ディーラーの得点は{$dealerPoint}です。" . PHP_EOL;

        $player = abs($this->rule->getPoint() - $playerPoint);
        $dealer = abs($this->rule->getPoint()  - $dealerPoint);
        if ($player < $dealer && $this->isPlayerPoint($playerPoint)) {
            echo 'あなたの勝ちです。' . PHP_EOL;
        } elseif ($dealer === $player && $this->isPlayerPoint($playerPoint)) {
            echo '引き分けです。' . PHP_EOL;
        } else {
            echo 'ディーラーの勝ちです。' . PHP_EOL;
        }
    }

    private function isPlayerPoint(int $point): bool
    {
        return $point <= $this->rule->getPoint();
    }
}
