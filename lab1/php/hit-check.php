<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $tableRows = "";
    if (isset($_SESSION["tableRows"])) {
        $tableRows = $_SESSION["tableRows"];
    }


    $currentDateTime = date('Y-m-d H:i:s');
    $start = microtime(true);

    $check = [];
    $x = $_POST["x"];
    $y = $_POST["y"];
    $r = $_POST["r"];

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

    $executionTime = microtime(true) - $start;

    $row = "<tr>
        <td>$currentDateTime</td>
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

?>


