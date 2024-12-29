<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_name'])) {
    $task_name = $_POST['task_name'];
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Insert the task with user_id
    $sql = "INSERT INTO tasks (task_name, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $task_name, $user_id); // Bind task name and user_id

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirect back to index.php
    } else {
        echo "Error adding task.";
    }
}

$conn->close();
?>