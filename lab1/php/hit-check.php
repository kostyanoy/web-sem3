<?php
// activate on post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["init"])) {
        init_request();
    } else {
        process_request();
    }
}

// return saved rows
function init_request()
{
    start_session();
    echo createHtmlTableRows(get_storage_value("tableData", []));

}

// process new row
function process_request()
{
    if (!(validate_number($_POST, "x") && validate_number($_POST, "y") && validate_number($_POST, "r")
        && validate_number($_POST, "timezoneOffsetMinutes"))) {
        exit("Sorry not valid");
    }

    // session storage - save table data
    start_session();
    $tableData = get_storage_value("tableData", []);

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

    $newRow = [
        'formattedDateTime' => $formattedDateTime,
        'executionTime' => $executionTime,
        'r' => $r,
        'x' => $x,
        'y' => $y,
        'inside' => $inside,
    ];

    $tableData[] = $newRow;
    
    // save  to storage
    $tableRows = createHtmlTableRows($tableData);
    save_storage_value("tableData", $tableData);

    //return table
    echo $tableRows;
}

// create html table content from given data
function createHtmlTableRows($data) : string {
    $result = "";
    foreach ($data as $row) {
        $result .= "<tr>";
        $result .= "<td>{$row['formattedDateTime']}</td>";
        $result .= "<td>{$row['executionTime']}</td>";
        $result .= "<td>{$row['r']}</td>";
        $result .= "<td>{$row['x']}</td>";
        $result .= "<td>{$row['y']}</td>";
        $result .= "<td>{$row['inside']}</td>";
        $result .= "</tr>";
    }
    return $result;
}

// check if a point inside figure
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
function start_session()
{
    session_start();
}

// get value from session storage by name
function get_storage_value($name, $default="")
{
    $result = $default;
    if (isset($_SESSION[$name])) {
        $result = $_SESSION[$name];
    }
    return $result;
}

// set value in session storage by name
function save_storage_value($name, $value)
{
    $_SESSION[$name] = $value;
}

// get current time with given offset in minutes
function getCurrentTime($offsetMinutes)
{
    date_default_timezone_set('UTC');
    $timestamp = time() + ($offsetMinutes * 60); 
    return date('Y-m-d H:i:s', $timestamp);
}

// check if value is set and a number
function validate_number($storage, $arg)
{
    return isset($storage[$arg]) && is_numeric($storage[$arg]);
}
