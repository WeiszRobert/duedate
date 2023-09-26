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
    public function testDateTimeComparison()
    {
        $expectedDateTime = new DateTime('2023-09-26 14:30:00');
        $actualDateTime = new DateTime('2023-09-26 14:30:00');

        // Use PHPUnit assertions to compare the DateTime objects
        $this->assertEquals($expectedDateTime, $actualDateTime);
    }
}