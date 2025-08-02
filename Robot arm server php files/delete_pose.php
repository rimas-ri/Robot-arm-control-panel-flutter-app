<?php
include 'db.php';

$id = $_POST['id'];
$conn->query("DELETE FROM pose WHERE id = $id");
$conn->close();

header("Location: index.php");
exit();
