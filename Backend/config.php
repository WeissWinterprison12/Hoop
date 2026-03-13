<?php
$conn = new mysqli("localhost", "root", "", "hooper_fits");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
