<?php declare(strict_types=1);
namespace App;

use DateTime;

define('START_WORKING_HOUR', 9);
define('END_WORKING_HOUR', 17);

class DueDateCalculator {
    public static function CalculateDueDate(DateTime $submitDate, int $turnaroundTime) : DateTime
    {
        self::CheckIsValidDate($submitDate);
        self::CheckIsValidTurnaroundTime($turnaroundTime);

        $dueDate = clone $submitDate;
        $taskMinutes = $turnaroundTime * 60;

        while ($taskMinutes > 0) {
            $remainingMinutesToday = self::GetRemainingMinutesToday($dueDate);
            if ($taskMinutes > $remainingMinutesToday) {
                $modifier = (self::IsFriday($dueDate) ? '+3 day' : '+1 day') . ' ' . START_WORKING_HOUR . ':00';
                $dueDate->modify($modifier);
                $taskMinutes -= $remainingMinutesToday;
            } else {
                $dueDate->modify('+' . $taskMinutes . ' minutes');
                $taskMinutes = 0;
            }
        }

        return $dueDate;
    }

    private static function GetRemainingMinutesToday(DateTime $date) : int {
        return END_WORKING_HOUR * 60 - intval($date->format('H')) * 60 - $date->format('i');
    }

    private static function IsFriday(DateTime $date) : bool {
        return intval($date->format('N')) === 5;
    }

    private static function IsWeekday(DateTime $date) : bool {
        return $date->format('N') < 6;
    }

    private static function IsWorkingHour(DateTime $date) : bool {
        return $date->format('H') >= START_WORKING_HOUR && $date->format('H') < END_WORKING_HOUR;
    }

    private static function IsWorkingDate(DateTime $date) : bool {
        return self::IsWeekday($date) && self::IsWorkingHour($date);
    }
    

    private static function CheckIsValidDate(DateTime $date) : void {
        if (!self::IsWorkingDate($date)) {
            throw new Exceptions\InvalidWorkingdayException();
        }
    }

    private static function CheckIsValidTurnaroundTime(int $turnaroundTime) : void {
        if ($turnaroundTime < 0) {
            throw new Exceptions\InvalidTurnaroundTimeException();
        }
    }

}