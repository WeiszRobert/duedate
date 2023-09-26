<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\DueDateCalculator;
use PHPUnit\Framework\TestCase;

define('TEST_FORMAT', "Y-m-d h:iA");

final class DateTest extends TestCase
{
    /** @test */
    public function submitDateIsSameDay() {
        $submitDateString = "2023-09-28 01:30PM"; //Thursday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2023-09-28 02:30PM"; //Thursday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function submitDateIsNextDay() {
        $submitDateString = "2023-09-28 04:30PM"; //Thursday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2023-09-29 09:30AM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function submitDateIsNextWeek() {
        $submitDateString = "2023-09-29 04:30PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2023-10-02 09:30AM"; //Monday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsOneWeek() {
        $submitDateString = "2023-09-29 04:30PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 8*5;

        $expectedDateString = "2023-10-06 04:30PM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsMoreThanOneWeek() {
        $submitDateString = "2023-09-29 04:30PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 8*5+1;

        $expectedDateString = "2023-10-09 09:30AM"; //Monday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::CalculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

}