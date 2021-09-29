<?php

declare(strict_types=1);

use Loader\Loader;
use BlackJack\BlackJack;

require(__DIR__ . '/lib/Loader.php');
require(__DIR__ . '/lib/BlackJack.php');

$loader = new Loader(__DIR__, ['lib']);
$game = new BlackJack();
$game->start();
