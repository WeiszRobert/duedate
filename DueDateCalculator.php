<?php

define('WORKING_HOURS', 8);

class DueDateCalculator {
    public static function CalculateDueDate($submitDate, $turnaroundTime) {
        if (!self::IsWorkingDay($submitDate)) {
            throw new Exception("Submit date must be a working day!");
        }

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
        return $date->format('H') >= 9 && $date->format('H') < 17;
    }

    private static function IsWorkingDay($date) {
        return !self::IsWeekend($date) && self::IsWorkingHour($date);
    }

    public static function test(){
        return "Hello World!";
    }
}