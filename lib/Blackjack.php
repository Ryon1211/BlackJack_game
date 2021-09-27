<?php

require('Rule.php');
require('CardDeck.php');
require('Player.php');
require('Dealer.php');

class BlackJack
{
    const POINT = 21;

    private Rule $rule;
    private CardDeck $cardDeck;
    private Player $player;
    private Dealer $dealer;

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

    public function start(): void
    {
        // メッセージ
        echo 'ブラックジャックを開始します。' . PHP_EOL;
        // プレイヤーがカードデッキからカードを引く
        $this->player->initDrawCard();
        // ディーラーがカードデッキからカードを引く
        $this->dealer->initDrawCard();
        // プレイヤーのターン
        $this->player->drawCard();
        // ディーラーのターン
        $this->dealer->drawCard();
        // 勝敗を判定する
        $this->judgeWinner();
        // メッセージ
        echo 'ブラックジャックを終了します。' . PHP_EOL;
    }

    public function judgeWinner(): void
    {
        $playerPoint = $this->player->getPoint();
        $dealerPoint = $this->dealer->getPoint();

        echo "あなたの得点は{$playerPoint}です。" . PHP_EOL;
        echo "ディーラーの得点は{$dealerPoint}です。" . PHP_EOL;

        $player = abs(Self::POINT - $playerPoint);
        $dealer = abs(Self::POINT - $dealerPoint);

        if ($player < $dealer) {
            echo 'あなたの勝ちです。' . PHP_EOL;
        } elseif ($dealer < $player) {
            echo 'ディーラーの勝ちです。' . PHP_EOL;
        } elseif ($dealer === $player) {
            echo '引き分けです。' . PHP_EOL;
        }
    }
}
