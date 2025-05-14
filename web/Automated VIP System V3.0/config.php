<?php
$db_host = "127.0.0.1";
$db_user = "DBUser";
$db_pass = "DBUserPassword";
$db_name = "sourcebans";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}