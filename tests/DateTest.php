<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\DueDateCalculator;
use PHPUnit\Framework\TestCase;

!defined('TEST_FORMAT') && define('TEST_FORMAT', "Y-m-d h:iA");

final class DateTest extends TestCase
{
    /** @test */
    public function resolveDateIsSameDay() {
        $submitDateString = "2023-09-28 01:30PM"; //Thursday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2023-09-28 02:30PM"; //Thursday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function resolveDateIsNextDay() {
        $submitDateString = "2023-09-28 04:30PM"; //Thursday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2023-09-29 09:30AM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function resolveDateIsNextWeek() {
        $submitDateString = "2023-09-29 04:30PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2023-10-02 09:30AM"; //Monday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function resolveDateIsEndOfWorkinghour() {
        $submitDateString = "2023-09-29 04:00PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2023-09-29 05:00PM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsOneDay() {
        $submitDateString = "2023-09-27 04:30PM"; //Wednesday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 8;

        $expectedDateString = "2023-09-28 04:30PM"; //Thursday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsOneDayWithWeekend() {
        $submitDateString = "2023-09-29 04:30PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 8;

        $expectedDateString = "2023-10-02 04:30PM"; //Monday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsMoreThanOneDayWithWeekend() {
        $submitDateString = "2023-09-28 04:30PM"; //Thursday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 9;

        $expectedDateString = "2023-10-02 09:30AM"; //Monday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsOneWeek() {
        $submitDateString = "2023-09-25 09:00AM"; //Monday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 40;

        $expectedDateString = "2023-09-29 05:00PM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsOneWeekWithWeekend() {
        $submitDateString = "2023-09-29 04:30PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 40;

        $expectedDateString = "2023-10-06 04:30PM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsMoreThanOneWeek() {
        $submitDateString = "2023-09-29 04:30PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 41;

        $expectedDateString = "2023-10-09 09:30AM"; //Monday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function turnaroundTimeIsOneYear() {
        $submitDateString = "2023-09-29 04:30PM"; //Friday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 8*5*52;

        $expectedDateString = "2024-09-27 04:30PM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function submitTimeIsLeapDay() {
        $submitDateString = "2024-02-29 04:30PM"; //Thursday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2024-03-01 09:30AM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function resolveTimeIsLeapDay() {
        $submitDateString = "2024-02-28 04:30PM"; //Thursday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 1;

        $expectedDateString = "2024-02-29 09:30AM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

    /** @test */
    public function timePeriodHasLeapDay() {
        $submitDateString = "2024-02-28 04:30PM"; //Thursday
        $submitDateTime = DateTime::createFromFormat(TEST_FORMAT, $submitDateString);
        $turnaroundTime = 9;

        $expectedDateString = "2024-03-01 09:30AM"; //Friday
        $expctedDateTime = DateTime::createFromFormat(TEST_FORMAT, $expectedDateString);
        $calculatedDateTime = DueDateCalculator::calculateDueDate($submitDateTime, $turnaroundTime);

        $this->assertEquals($expctedDateTime, $calculatedDateTime);
    }

}