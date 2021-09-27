<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/CardDeck.php');
require_once(__DIR__ . '/../lib/Player.php');
require_once(__DIR__ . '/../lib/Rule.php');

final class PlayerTest extends TestCase
{
    public function testInitDraw(): void
    {
        $rule = new Rule();
        $cardDeck = new CardDeck();
        $player = new Player($rule, $cardDeck);
        // 標準出力のバッファを開始
        ob_start();
        $player->initDrawCard();
        // 標準出力のバッファを閉じて、結果の取得
        $message = ob_get_clean();
        $regExp = '/^あなたの引いたカードは(クラブ|スペード|ダイヤ|ハート)の([2-9]|10|A|J|Q|K)です。\nあなたの引いたカードは(クラブ|スペード|ダイヤ|ハート)の([2-9]|10|A|J|Q|K)です。/';
        // 正規表現によるマッチングで出力のテスト
        $this->assertMatchesRegularExpression($regExp, $message);
    }

    public function testDraw(): void
    {
        $rule = new Rule();
        $cardDeck = new CardDeck();
        $dealer = new Dealer($rule, $cardDeck);

        $dealer->draw();
        $this->assertGreaterThan(0, $dealer->getPoint());
    }

    public function testDrawCardsFromDeck(): void
    {
        $rule = new Rule();
        $cardDeck = new CardDeck();
        $dealer = new Dealer($rule, $cardDeck);
        $this->assertNotContains($dealer->drawCardsFromDeck(), $cardDeck->cards);
    }
}
