<?php
include 'db.php';

$sql = "INSERT INTO run (servo1, servo2, servo3, servo4, servo5, servo6, status) VALUES (?, ?, ?, ?, ?, ?, 1)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiiii",
    $_POST['servo1'],
    $_POST['servo2'],
    $_POST['servo3'],
    $_POST['servo4'],
    $_POST['servo5'],
    $_POST['servo6']
);
$stmt->execute();
$stmt->close();

$conn->close();
header("Location: index.php");
exit();
