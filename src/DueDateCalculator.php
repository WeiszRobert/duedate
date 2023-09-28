<?php declare(strict_types=1);
namespace App;

use DateTime;
use InvalidArgumentException;

!defined('START_WORKING_HOUR') && define('START_WORKING_HOUR', 9);
!defined('END_WORKING_HOUR') && define('END_WORKING_HOUR', 17);

class DueDateCalculator {

    /**
     * Calculates the due date of a task based on the submit date and the turnaround time.
     * 
     * @param DateTime $submitDate The date when the task was submitted.
     * @param int $turnaroundTime The time in hours it takes to complete the task.
     * 
     * @return DateTime The due date of the task.
     * 
     * @throws InvalidArgumentException If the submit date is not a working date (Weekdays between 9AM and 5PM).
     * @throws InvalidArgumentException If the turnaround time is not a positive integer.
     */
    public static function calculateDueDate(DateTime $submitDate, int $turnaroundTime) : DateTime
    {
        self::checkIsValidDate($submitDate);
        self::checkIsValidTurnaroundTime($turnaroundTime);

        $dueDate = clone $submitDate;
        $taskMinutes = $turnaroundTime * 60;

        while ($taskMinutes > 0) {
            $remainingMinutesToday = self::getRemainingMinutesToday($dueDate);
            if ($taskMinutes > $remainingMinutesToday) {
                $nextWorkingDayModifier = (self::isFriday($dueDate) ? '+3 day' : '+1 day') . ' ' . START_WORKING_HOUR . ':00';
                $dueDate->modify($nextWorkingDayModifier);
                $taskMinutes -= $remainingMinutesToday;
            } else {
                $dueDate->modify('+' . $taskMinutes . ' minutes');
                $taskMinutes = 0;
            }
        }

        return $dueDate;
    }

    private static function getRemainingMinutesToday(DateTime $date) : int {
        return END_WORKING_HOUR * 60 - intval($date->format('H')) * 60 - $date->format('i');
    }

    private static function isFriday(DateTime $date) : bool {
        return intval($date->format('N')) === 5;
    }

    private static function isWeekday(DateTime $date) : bool {
        return intval($date->format('N')) < 6;
    }

    private static function isWorkingHour(DateTime $date) : bool {
        return intval($date->format('H')) >= START_WORKING_HOUR && intval($date->format('H')) < END_WORKING_HOUR;
    }

    private static function isWorkingDate(DateTime $date) : bool {
        return self::isWeekday($date) && self::isWorkingHour($date);
    }
    

    private static function checkIsValidDate(DateTime $date) : void {
        if (!self::isWorkingDate($date)) {
            throw new InvalidArgumentException("Submit date must be a working date! (Weekdays between 9AM and 5PM)");
        }
    }

    private static function checkIsValidTurnaroundTime(int $turnaroundTime) : void {
        if ($turnaroundTime < 0) {
            throw new InvalidArgumentException("Turnaround time must be a positive integer!");
        }
    }

}