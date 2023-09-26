<?php
namespace App\Exceptions;
use Exception;

class InvalidTurnaroundTimeException extends Exception {
    public function errorMessage() {
        return "Turnaround time must be a positive integer!";
    }
}