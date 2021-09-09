<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/test.php');

final class StackTest extends TestCase
{
    public function testTests(): void
    {
        $this->assertSame('test', test());
    }
}
