<?php

declare(strict_types=1);

namespace Role;

use Card\Card;
use CardDeck\CardDeck;
use Rule\Rule;

abstract class Role
{
    /**
     * 今まで引いたカードを保存する配列
     *
     * @var array<int,Card>
     */
    protected array $cards;

    /**
     * 得点を保存する変数
     *
     * @var integer
     */
    protected int $point = 0;

    /**
     * コンストラクタ
     *
     * @param Rule $rule
     * @param CardDeck $cardDeck
     */
    public function __construct(public Rule $rule, public CardDeck $cardDeck)
    {
    }

    /**
     * ゲーム開始時に複数枚のカードを引く処理
     *
     * @return void
     */
    abstract public function firstDrawCard(): void;

    /**
     * ターンになったときカードを引く処理
     *
     * @return bool
     */
    abstract public function drawCard(): bool;

    /**
     * カードを引いた際の一連の処理
     *
     * $this->drawCardsFromDeckを実行しカードを引く
     * 引いたカードの情報を$this->cardsに保存
     * $this->setPointを実行し点数の計算と保存
     *
     * @return void
     */
    public function draw(): void
    {
        $card = $this->drawCardsFromDeck();
        $this->cards[] = $card;
        $this->setPoint($this->cards);
    }

    /**
     * CardDeckインスタンスのdrawCardメソッドを実行
     *
     * @return Card
     */
    public function drawCardsFromDeck(): Card
    {
        return $this->cardDeck->drawCard();
    }

    /**
     * 保持している得点を返却
     *
     * @return integer
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * 得点の計算と保存をする
     *
     * ポイントの計算はRuleインスタンスのcalcPointメソッドを実行
     *　結果を保存
     *
     * @param array <int, Card>$cards
     * @return void
     */
    protected function setPoint(array $cards): void
    {
        $this->point = $this->rule->calcPoint($cards);
    }

    /**
     * 引いたカードのスートと番号を取得する
     *
     * @param integer $num
     * @return array<string, string>
     */
    public function getSuitAndNumber(int $num): array
    {
        return [
            'suit' => $this->cards[$num]->cardSuit,
            'number' => $this->cards[$num]->cardNumber
        ];
    }
}
