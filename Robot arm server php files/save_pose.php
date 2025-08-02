<?php
include 'db.php';

$servo1 = $_POST['servo1'];
$servo2 = $_POST['servo2'];
$servo3 = $_POST['servo3'];
$servo4 = $_POST['servo4'];

$sql = "INSERT INTO pose (servo1, servo2, servo3, servo4) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $servo1, $servo2, $servo3, $servo4);

if ($stmt->execute()) {
    echo "✅ Saved to database.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
