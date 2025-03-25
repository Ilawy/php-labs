<?php
require_once "lib/validator.php";
$formResult = [
    'room' => validate('room'),
    'duration' => validate('duration', custom: fn($value)=>[((int)$value >= 1) && ((int)$value <= 6), "duration must be between 1 and 6 hours"]),
    'date' => validate('date'),
];


$values = handleValidationResult($formResult, "/reservations");

try{
    createReservation((int)$_SESSION["id"], $values["room"], $values["duration"], $values["date"]);
}catch(Throwable $e){
    handleValidationResult(['_' => [false, $e->getMessage()]], "/reservations");
}