<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "cebutechapparel";

$mysqli = new mysqli($host, $user, $pass, $dbname);
if ($mysqli->connect_errno) {
    die ("Connection error" . $mysqli->connect_error);
}

return $mysqli;