<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use CardDeck\CardDeck;
use CpuPlayer\CpuPlayer;
use Rule\Rule;

require_once(__DIR__ . '/../lib/Role.php');
require_once(__DIR__ . '/../lib/CardDeck.php');
require_once(__DIR__ . '/../lib/CpuPlayer.php');
require_once(__DIR__ . '/../lib/Rule.php');
require_once(__DIR__ . '/../lib/Utility.php');

final class CpuPlayerTest extends TestCase
{
    public function testFirstDrawCard(): void
    {
        $rule = new Rule();
        $cardDeck = new CardDeck();
        $player = new CpuPlayer($rule, $cardDeck, 'Cpu1');
        // 標準出力のバッファを開始
        ob_start();
        $player->firstDrawCard();
        // 標準出力のバッファを閉じて、結果の取得
        $message = ob_get_clean();
        $regExp = '/^Cpu1の引いたカードは(クラブ|スペード|ダイヤ|ハート)の([2-9]|10|A|J|Q|K)です。\nCpu1の引いたカードは(クラブ|スペード|ダイヤ|ハート)の([2-9]|10|A|J|Q|K)です。/';
        // 正規表現によるマッチングで出力のテスト
        $this->assertMatchesRegularExpression($regExp, $message);
    }

    public function testDraw(): void
    {
        $rule = new Rule();
        $cardDeck = new CardDeck();
        $player = new CpuPlayer($rule, $cardDeck, 'Cpu1');

        $player->draw();
        $this->assertGreaterThan(0, $player->getPoint());
    }

    public function testDrawCardsFromDeck(): void
    {
        $rule = new Rule();
        $cardDeck = new CardDeck();
        $player = new CpuPlayer($rule, $cardDeck, 'Cpu1');
        $this->assertNotContains($player->drawCardsFromDeck(), $cardDeck->cards);
    }

    public function testGetPlayerName(): void
    {
        $rule = new Rule();
        $cardDeck = new CardDeck();
        $player = new CpuPlayer($rule, $cardDeck, 'Cpu1');
        $this->assertSame('Cpu1', $player->getPlayerName());
    }
}
