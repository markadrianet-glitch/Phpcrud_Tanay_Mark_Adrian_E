<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["add_student"])) {

    $firstname = trim($_POST["Firstname"] ?? "");
    $lastname = trim($_POST["Lastname"] ?? "");

    if ($firstname !== "" && $lastname !== "") {
        $stmt = $conn->prepare(
            "INSERT INTO students (Firstname, Lastname) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $firstname, $lastname);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit;
    }
}

$result = $conn->query("SELECT * FROM students ORDER BY ID DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Records</title>
    <style>
        body { font-family: Arial; background: #f2f4f8; margin: 30px; }
        .container { max-width: 900px; margin: auto; }
        .card { background: white; padding: 24px; border-radius: 10px; }
        input { padding: 10px; margin: 5px 0 12px; box-sizing: border-box; }
        form.add input { width: 100%; }
        button, .btn { padding: 9px 13px; border: 0; border-radius: 5px;
            color: white; cursor: pointer; text-decoration: none; }
        .green { background: #198754; }
        .blue { background: #0d6efd; }
        .red { background: #dc3545; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 11px; text-align: left; }
        th { background: #e9edf2; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>Student Records</h1>

        <h3>Add Student</h3>
        <form class="add" method="post" action="index.php">
            <label>First Name</label>
            <input type="text" name="Firstname" required>

            <label>Last Name</label>
            <input type="text" name="Lastname" required>

            <button class="green" type="submit" name="add_student">
                Add Student
            </button>
        </form>

        <h3>Student List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$row["ID"] ?></td>
                        <td><?= htmlspecialchars($row["Firstname"]) ?></td>
                        <td><?= htmlspecialchars($row["Lastname"]) ?></td>
                        <td>
                            <a class="btn blue"
                               href="update.php?id=<?= (int)$row["ID"] ?>">
                                Edit
                            </a>
                            <a class="btn red"
                               href="delete.php?id=<?= (int)$row["ID"] ?>"
                               onclick="return confirm('Delete this student?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No student records found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

        <p><a href="calculator.php">Open Calculator</a></p>
    </div>
</div>
</body>
</html>
