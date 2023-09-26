<?php
namespace App\Exceptions;
use Exception;

class InvalidWorkingdayException extends Exception {
    public function errorMessage() {
        return "Submit date must be a working day!";
    }
}
