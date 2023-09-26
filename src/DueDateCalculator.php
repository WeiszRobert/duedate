<?php
namespace App;

use DateTime;

define('WORKING_HOURS', 8);
define('START_WORKING_HOUR', 9);
define('END_WORKING_HOUR', 17);

class DueDateCalculator {
    public static function CalculateDueDate(DateTime $submitDate, int $turnaroundTime) : DateTime
    {
        self::CheckIsValidDate($submitDate);
        self::CheckIsValidTurnaroundTime($turnaroundTime);

        $dueDate = clone $submitDate;
        
        $daysLeft = floor($turnaroundTime / WORKING_HOURS);
        $hoursLeft = $turnaroundTime % WORKING_HOURS;

        while ($hoursLeft > 0) {
            $dueDate->modify('+1 hour');
            if (self::IsWorkingHour($dueDate)) {
                $hoursLeft--;
            }
        }

        for ($i = 0; $i < $daysLeft; $i++) {
            $dueDate->modify('+1 day');
            if (self::IsWeekend($dueDate)) {
                $dueDate->modify('+2 day');
            }
        }

        return $dueDate;
    }

    private static function IsWeekend($date) {
        return $date->format('N') >= 6;
    }

    private static function IsWorkingHour($date) {
        return $date->format('H') >= START_WORKING_HOUR && $date->format('H') < END_WORKING_HOUR;
    }

    private static function IsWorkingDay($date) {
        return !self::IsWeekend($date) && self::IsWorkingHour($date);
    }
    

    private static function CheckIsValidDate($date) {
        if (!self::IsWorkingDay($date)) {
            throw new Exceptions\InvalidWorkingdayException();
        }
    }

    private static function CheckIsValidTurnaroundTime($turnaroundTime) {
        if ($turnaroundTime < 0) {
            throw new Exceptions\InvalidTurnaroundTimeException();
        }
    }

    public static function test(){
        return "Hello World!";
    }
}