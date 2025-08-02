<?php
$conn = new mysqli("localhost", "root", "root", "TASK3", 8889);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
