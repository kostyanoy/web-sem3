<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!(validate_number($_POST["x"]) && validate_number($_POST["y"]) && validate_number($_POST["r"])
    && validate_number($_POST["timezoneOffsetMinutes"]))) {
        exit();
    }

    session_start();

    $tableRows = "";
    // if (isset($_SESSION["tableRows"])) {
    //     $tableRows = $_SESSION["tableRows"];
    // }

    $timezoneOffsetMinutes = $_POST['timezoneOffsetMinutes'];
    $formattedDateTime = getCurrentTime($timezoneOffsetMinutes);

    $start = microtime(true);

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

    $row = "<tr>
        <td>$formattedDateTime</td>
        <td>$executionTime</td>
        <td>$r</td>
        <td>$x</td>
        <td>$y</td>
        <td>$inside</td>
    </tr>";

    $tableRows = $tableRows . $row;

    $_SESSION["tableRows"] = $tableRows;

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

function getCurrentTime($offsetMinutes){
    
    $time = new DateTime();
    $time->add(new DateInterval(('PT' . $offsetMinutes . 'M')));
    
    return $time->format('Y-m-d H:i:s T');
}

function validate_number($arg){
    return isset($arg) && is_numeric($arg);
}