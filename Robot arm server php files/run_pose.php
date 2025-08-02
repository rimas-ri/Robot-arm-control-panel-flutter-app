<?php
include 'db.php';

$id = $_POST['id'];
$result = $conn->query("SELECT * FROM pose WHERE id = $id");
if ($row = $result->fetch_assoc()) {
    $sql = "INSERT INTO run (servo1, servo2, servo3, servo4, servo5, servo6, status) VALUES (?, ?, ?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiii", $row['servo1'], $row['servo2'], $row['servo3'], $row['servo4'], $row['servo5'], $row['servo6']);
    $stmt->execute();
}

$conn->close();
header("Location: index.php");
exit();
