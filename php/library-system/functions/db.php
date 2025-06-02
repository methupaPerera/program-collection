<?php

$username = "root";
$password = null;
$hostname = "localhost";
$database = "libsys";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed : " . $conn->connect_error);
}