<?php
$conn = new mysqli("localhost", "root", "", "todo_list");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Update task status to completed
    $sql = "UPDATE tasks SET status = 'completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $task_id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect back to the main page
    } else {
        echo "Error updating task.";
    }
}

$conn->close();
?>
