<?php
$host = "localhost";
$db_user = "infost490fa2507_ryan";
$db_pass = "BloodClotGPS01";
$db_name = "infost490fa2507_gpsense";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>