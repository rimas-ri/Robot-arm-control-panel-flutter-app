<?php
include 'db.php';

$sql = "UPDATE run SET status = 0 WHERE status = 1";
$conn->query($sql);
$conn->close();

echo "Status updated to 0";
?>
