<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\DueDateCalculator;
use PHPUnit\Framework\TestCase;

!defined('TEST_FORMAT') && define('TEST_FORMAT', "Y-m-d h:iA");

final class ParameterTest extends TestCase
{
    /** @test */
    public function submitDateIsWeekend() {
        $dateString = "2023-09-30 04:30PM"; //Saturday
        $submitDate = DateTime::createFromFormat(TEST_FORMAT, $dateString);
        $turnaroundTime = 1;
        
        $this->expectException(InvalidArgumentException::class);
        $dueDate = DueDateCalculator::CalculateDueDate($submitDate, $turnaroundTime);
    }

    /** @test */
    public function submitDateIsWorkingDay() {
        $dateString = "2023-09-26 04:30PM"; //Tuesday
        $submitDate = DateTime::createFromFormat(TEST_FORMAT, $dateString);
        $turnaroundTime = 1;
        
        $this->expectNotToPerformAssertions();
        $dueDate = DueDateCalculator::CalculateDueDate($submitDate, $turnaroundTime);
    }

    /** @test */
    public function turnaroundTimeIsPositive() {
        $dateString = "2023-09-27 04:30PM"; //Wednesday
        $submitDate = DateTime::createFromFormat(TEST_FORMAT, $dateString);
        $turnaroundTime = 1;
        
        $this->expectNotToPerformAssertions();
        $dueDate = DueDateCalculator::CalculateDueDate($submitDate, $turnaroundTime);
    }

    /** @test */
    public function turnaroundTimeIsNegative() {
        $dateString = "2023-09-26 04:30PM"; //Tuesday
        $submitDate = DateTime::createFromFormat(TEST_FORMAT, $dateString);
        $turnaroundTime = (-1);
        
        $this->expectException(InvalidArgumentException::class);
        $dueDate = DueDateCalculator::CalculateDueDate($submitDate, $turnaroundTime);
    }
}