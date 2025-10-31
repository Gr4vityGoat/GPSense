<?php
$host = "localhost";
$db_user = "infost490fa2507";
$db_pass = "GPSense!@#";
$db_name = "infost490fa2507_gpsense";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>