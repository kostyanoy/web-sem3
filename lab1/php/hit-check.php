<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Log all sent parameters
    $logMessage = "Received form parameters:\n";
    foreach ($_POST as $key => $value) {
        $logMessage .= "$key: $value\n";
    }

    echo $logMessage;
    print_r($_POST);
}