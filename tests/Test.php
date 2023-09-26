<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\DueDateCalculator;
use PHPUnit\Framework\TestCase;

final class Test extends TestCase
{
    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'Hello World!',
            DueDateCalculator::test()
        );
    }
}