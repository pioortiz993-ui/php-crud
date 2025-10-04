<?php
require_once '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ✅ Make sure your table and columns are correct
    $sql = "INSERT INTO tbl_user (username, email, course, password) VALUES (?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // ✅ If prepare() fails, show the actual MySQL error
    if (!$stmt) {
        die("Prepare failed: " . htmlspecialchars($conn->error) . "<br>SQL: " . htmlspecialchars($sql));
    }

    // Bind parameters
    $stmt->bind_param("ssss", $username, $email, $course, $password);

    // Execute
    if ($stmt->execute()) {
        header("Location: ../pages/user_list.php?success=1");
        exit;
    } else {
        die("Execute failed: " . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>