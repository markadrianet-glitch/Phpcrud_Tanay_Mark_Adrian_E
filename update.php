<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $firstname = trim($_POST["Firstname"] ?? "");
    $lastname = trim($_POST["Lastname"] ?? "");

    if (!$id || $firstname === "" || $lastname === "") {
        exit("Please complete all fields correctly.");
    }

    $stmt = $conn->prepare(
        "UPDATE students
         SET Firstname = ?, Lastname = ?
         WHERE ID = ?"
    );

    $stmt->bind_param("ssi", $firstname, $lastname, $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: index.php");
        exit;
    }

    $stmt->close();
    exit("Error updating student.");
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    exit("Invalid student ID. <a href='index.php'>Go Back</a>");
}

$stmt = $conn->prepare(
    "SELECT ID, Firstname, Lastname
     FROM students
     WHERE ID = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) {
    exit("Student not found. <a href='index.php'>Go Back</a>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Student</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 450px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
            box-sizing: border-box;
        }

        button, a {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background: #198754;
            color: white;
        }

        a {
            background: #6c757d;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Update Student</h2>

        <form action="update.php" method="POST">
            <input
                type="hidden"
                name="id"
                value="<?= (int)$student['ID'] ?>"
            >

            <label>First Name</label>
            <input
                type="text"
                name="Firstname"
                value="<?= htmlspecialchars($student['Firstname']) ?>"
                required
            >

            <label>Last Name</label>
            <input
                type="text"
                name="Lastname"
                value="<?= htmlspecialchars($student['Lastname']) ?>"
                required
            >

            <button type="submit">Update Student</button>
            <a href="index.php">Cancel</a>
        </form>
    </div>
</body>
</html>
