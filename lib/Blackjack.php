<?php

declare(strict_types=1);

namespace BlackJack;

use CardDeck\CardDeck;
use CpuPlayer\CpuPlayer;
use Dealer\Dealer;
use Player\Player;
use Rule\Rule;
use Utility\Utility;

class BlackJack
{
    /**
     * @vat int
     */
    private const MAX_CPU_PLAYER = 2;

    private CardDeck $cardDeck;
    /**
     * Cpuプレイヤーのリスト
     *
     * @var array<int, CpuPlayer>
     */
    private array $cpuPlayers;
    private Dealer $dealer;
    private Player $player;
    private Rule $rule;

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
        // CPUプレイヤーのインスタンスを作成する
        $this->cpuPlayers = $this->createCpuPlayer($this->rule, $this->cardDeck);
    }

    /**
     * ゲームの進行処理をする関数
     *
     * @return void
     */
    public function start(): void
    {
        Utility::showMsg('ブラックジャックを開始します。');
        // フラグの初期化
        $playerLoopFlg = true;
        $dealerLoopFlg = true;
        $firstTurn = true;

        // 最初のカードを引く
        $this->firstDrawCard();

        // ２順目以降
        while ($playerLoopFlg && $dealerLoopFlg) {
            $flg = [];
            // プレイヤーがカードを引く
            $flg[] = $this->drawPlayer($this->player);
            // cpuプレイヤーがカードを引く
            $flg += array_map(fn ($player) => $this->drawPlayer($player), $this->cpuPlayers);
            // プレイヤーが次のターンでカードを引くか判定
            $playerLoopFlg = $this->isPlayerLoop($flg);
            // ２順目終了時にディーラーが１順目で引いた２枚目カードを表示する
            $this->showDealerSecondCard($firstTurn);
            // ディーラーがカードを引く
            $dealerLoopFlg = $this->drawDealer($this->dealer);
            // 1順目かそれ以外か
            $firstTurn = false;
        }

        // 勝敗を判定する
        $this->judgeWinner();

        Utility::showMsg('ブラックジャックを終了します。');
    }

    /**
     * 最初のカードを引く
     *
     * @return void
     */
    public function firstDrawCard(): void
    {
        // プレイヤー、ディーラーがそれぞれカードデッキからカードを引く
        $this->player->firstDrawCard();
        array_map(fn ($player) => $player->firstDrawCard(), $this->cpuPlayers);
        $this->dealer->firstDrawCard();
    }

    /**
     * プレイヤーとCPUプレイヤーがカードを引く処理
     *
     * @return string
     */
    public function drawPlayer(Player | CpuPlayer $player): string
    {
        $next = false;

        if ($player->getPoint() < $this->rule->getWinningScore()) {
            $next = $player->drawCard();
        }

        return $next ? '' : 'stop';
    }

    /**
     * ディーラーがカードを引く処理
     *
     * @param Dealer $dealer
     * @param boolean $playerLoopFlg
     * @return boolean
     */
    public function drawDealer(Dealer $dealer): bool
    {
        return $dealer->drawCard();
    }

    /**
     * プレイヤーがカードを引き続けるかの判定
     *
     * @param array<int, string> $flg
     * @return boolean
     */
    public function isPlayerLoop(array $flg): bool
    {
        $countResult = array_count_values($flg);

        return !(array_key_exists('stop', $countResult)
            && $countResult['stop'] === count($this->cpuPlayers) + 1);
    }

    /**
     * ディーラーが２枚目に引いたカードを表示する
     *
     * @param boolean $flg
     * @return void
     */
    public function showDealerSecondCard(bool $flg): void
    {
        if ($flg) {
            $this->dealer->showSecondCard();
        }
    }

    /**
     * 勝者の判定を行う関数
     *
     * @return void
     */
    public function judgeWinner(): void
    {
        $dealerPoint = $this->dealer->getPoint();
        Utility::showMsg("ディーラーの得点は{$dealerPoint}です。");

        // プレイヤーの勝敗を決める
        $playerPoint = $this->player->getPoint();
        $this->displayWinnerMessage($playerPoint, $dealerPoint, 'あなた');

        // CPUプレイヤーの勝敗を決める
        foreach ($this->cpuPlayers as $player) {
            $playerPoint = $player->getPoint();
            $playerName = $player->getPlayerName();
            $this->displayWinnerMessage($playerPoint, $dealerPoint, $playerName);
        }
    }

    /**
     * 点数の差を絶対値で計算する関数
     *
     * @param integer $score
     * @return integer
     */
    public function calcScoreDiff(int $score): int
    {
        return abs($this->rule->getWinningScore() - $score);
    }

    /**
     * プレイやーの点数を判定
     *
     * @param integer $point
     * @return boolean
     */
    private function isPlayerPoint(int $point): bool
    {
        return $point <= $this->rule->getWinningScore();
    }

    /**
     * 勝者を表示する関数
     *
     * @param integer $playerPoint
     * @param integer $dealerPoint
     * @param string $name
     * @return void
     */
    public function displayWinnerMessage(int $playerPoint, int $dealerPoint, string $name): void
    {
        $playerDiff = $this->calcScoreDiff($playerPoint);
        $dealerDiff = $this->calcScoreDiff($dealerPoint);
        Utility::showMsg("{$name}の得点は{$playerPoint}です。");
        if ($playerDiff < $dealerDiff && $this->isPlayerPoint($playerPoint)) {
            $msg =  "{$name}の勝ちです。";
        } elseif ($dealerDiff === $playerDiff && $this->isPlayerPoint($playerPoint)) {
            $msg = '引き分けです。';
        } else {
            $msg = 'ディーラーの勝ちです。';
        }

        Utility::showMsg($msg);
    }

    /**
     * CPUプレイヤーのインスタンスを作成
     *
     * @param Rule $rule
     * @param CardDeck $cardDeck
     * @param string $name
     * @return array<int, CpuPlayer>
     */
    private function createCpuPlayer(Rule $rule, CardDeck $cardDeck, string $number = ''): array
    {
        Utility::showMsg('CPUプレイヤーの人数(0〜' . self::MAX_CPU_PLAYER . ')');
        $count = (int)Utility::getStdin($number);
        $cpuPlayer = [];

        if (2 < $count) {
            $count = self::MAX_CPU_PLAYER;
        }

        for ($i = 1; $i <= $count; $i++) {
            $name = "CPU{$i}";
            $cpuPlayer[$i] = new CpuPlayer($rule, $cardDeck, $name);
        }

        return $cpuPlayer;
    }
}
