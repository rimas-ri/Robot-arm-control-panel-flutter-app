<?php
include 'db.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM run WHERE status = 1 ORDER BY servo1 LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["message" => "No active run"]);
}

$conn->close();
?>
