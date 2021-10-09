<?php

declare(strict_types=1);

namespace Utility;

class Utility
{
    /**
     * 第１引数で受け取ったテキストをechoで表示する
     *
     * @param string $text
     * @param boolean $br
     * @return void
     */
    public static function showMsg(string $text, bool $br = true): void
    {
        echo $br ? $text . PHP_EOL : $text;
    }

    /**
     * 引数がない場合は、標準入力から値を受け取り返却する関数
     *
     * @param string $text
     * @return string
     */
    public static function getStdin(string $text = ''): string
    {
        return $text === '' ? trim(fgets(STDIN)) : $text;
    }
}
