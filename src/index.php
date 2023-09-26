<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\DueDateCalculator;

//var_dump("Hello World!");
//var_dump(DueDateCalculator::test());

$dateString = "2023-09-26 04:30PM";
$dateFormat = "Y-m-d h:iA";
$submitDate = DateTime::createFromFormat($dateFormat, $dateString);
//var_dump($submitDate);
$turnaroundTime = (-1);
$dueDate = 0;
try {
    $dueDate = DueDateCalculator::CalculateDueDate($submitDate, $turnaroundTime);
    var_dump($dueDate);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}