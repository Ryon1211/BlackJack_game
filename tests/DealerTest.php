<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use CardDeck\CardDeck;
use Dealer\Dealer;
use Rule\Rule;


require_once(__DIR__ . '/../lib/Role.php');
require_once(__DIR__ . '/../lib/CardDeck.php');
require_once(__DIR__ . '/../lib/Dealer.php');
require_once(__DIR__ . '/../lib/Rule.php');
require_once(__DIR__ . '/../lib/Utility.php');

final class DealerTest extends TestCase
{
    public function testFirstDraw(): void
    {
        $rule = new Rule();
        $cardDeck = new CardDeck();
        $dealer = new Dealer($rule, $cardDeck);
        // 標準出力のバッファを開始
        ob_start();
        $dealer->firstDrawCard();
        // 標準出力のバッファを閉じて、結果の取得
        $message = ob_get_clean();
        $regExp = '/^ディーラーの引いたカードは(クラブ|スペード|ダイヤ|ハート)の([2-9]|10|A|J|Q|K)です。\nディーラーの引いた２枚めのカードはわかりません。/';
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
