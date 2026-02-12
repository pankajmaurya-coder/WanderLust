<?php

function logError(string $message, string $level = "ERROR"): void{
    $file = __DIR__ . "/error.log";
    $date = date("Y-m-d H:i:s");

    $finalMessage = "[$date] [$level] $message\n";

    error_log($finalMessage, 3, $file);
}

?>
