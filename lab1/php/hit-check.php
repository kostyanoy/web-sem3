<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["init"])){
        init_request();
    } else {
        process_request();
    }
}
function init_request() {
    start_session();
    echo get_storage_value("tableRows");
}

function process_request(){
    if (!(validate_number($_POST, "x") && validate_number($_POST, "y") && validate_number($_POST, "r")
    && validate_number($_POST, "timezoneOffsetMinutes"))) {
        exit("Sorry not valid");
    }

    // session storage - save table 
    start_session();
    $tableRows = get_storage_value("tableRows");

    // format date-time
    $timezoneOffsetMinutes = $_POST['timezoneOffsetMinutes'];
    $formattedDateTime = getCurrentTime($timezoneOffsetMinutes);

    $start = microtime(true); // start timer

    $check = [];
    $x = floatval($_POST["x"]);
    $y = floatval($_POST["y"]);
    $r = floatval($_POST["r"]);

    if ($r <= 0)
        exit();

    if ($x <= 0 && $y >= 0) $check[] = 1;
    if ($x >= 0 && $y >= 0) $check[] = 2;
    if ($x >= 0 && $y <= 0) $check[] = 3;
    if ($x <= 0 && $y <= 0) $check[] = 4;

    $inside = "Нет";

    foreach ($check as $index) {
        $figure = $_POST["figure$index"];
        $figureR = ($_POST["radius$index"] === "r") ? $r : $r / 2;
        $figureH = ($_POST["height$index"] === "r") ? $r : $r / 2;
        $figureW = ($_POST["width$index"] === "r") ? $r : $r / 2;

        if (checkInsideFigure($figure, $figureR, $figureH, $figureW, $x, $y, $r)) {
            $inside = "Да";
            break;
        }
    }

    $executionTime = number_format((microtime(true) - $start) * 1_000_000);

    // result row
    $row = "<tr>
        <td>$formattedDateTime</td>
        <td>$executionTime</td>
        <td>$r</td>
        <td>$x</td>
        <td>$y</td>
        <td>$inside</td>
    </tr>";

    // save  to storage

    $tableRows = $tableRows . $row;
    save_storage_value("tableRows", $tableRows);

    echo $tableRows;
}

function checkInsideFigure($figure, $fr, $fh, $fw, $x, $y, $r): bool
{
    switch ($figure) {
        case "rectangle":
            return abs($x) <= $fw && abs($y) <= $fh;
        case "circle":
            return $x * $x + $y * $y <= $fr * $fr;
        case "rhombus":
            return abs($x) / (abs($fw) / $r) + abs($y) / (abs($fh) / $r) <= $r;
    }
    return false;
}

// open session storage
function start_session() {
    session_start();
}

// get value from session storage by name
function get_storage_value($name){
    $result = "";
    if (isset($_SESSION[$name])) {
        $result = $_SESSION[$name];
    }
    return $result;
}

// set value in session storage by name
function save_storage_value($name, $value){
    $_SESSION[$name] = $value;
}

// get current time with given offset in minutes
function getCurrentTime($offsetMinutes){
    
    $time = new DateTime();
    $time->add(new DateInterval(('PT' . $offsetMinutes . 'M')));
    
    return $time->format('Y-m-d H:i:s T');
}

// check if value is set and a number
function validate_number($storage, $arg){
    return isset($storage[$arg]) && is_numeric($storage[$arg]);
}