<?php
$servername = "localhost";
$username = "root";
$password = "polo0210";
$dbname = "main database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>