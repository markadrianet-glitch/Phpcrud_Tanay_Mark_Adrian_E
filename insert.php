<?php
require_once "database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = trim($_POST["Firstname"] ?? "");
    $lastname = trim($_POST["Lastname"] ?? "");

    if ($firstname === "" || $lastname === "") {
        $error = "Please complete all fields.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO students (Firstname, Lastname) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $firstname, $lastname);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: index.php");
            exit;
        }

        $error = "Unable to add student.";
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Student</title>
</head>
<body>
<h2>Add Student</h2>
<p><?= htmlspecialchars($error) ?></p>
<form method="post">
    <label>First Name:</label>
    <input name="Firstname" required>
    <br><br>
    <label>Last Name:</label>
    <input name="Lastname" required>
    <br><br>
    <button type="submit">Save Student</button>
</form>
<p><a href="index.php">Back to Student List</a></p>
</body>
</html>