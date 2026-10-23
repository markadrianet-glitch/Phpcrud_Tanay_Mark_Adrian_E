<?php
require_once "database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    exit("Invalid student ID. <a href='index.php'>Go back</a>");
}

$stmt = $conn->prepare("DELETE FROM students WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit;
?>
