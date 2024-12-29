<?php
$conn = new mysqli("localhost", "root", "", "todo_list");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Fetch task details
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $task_name = $_POST['task_name'];

        // Update task in database
        $sql = "UPDATE tasks SET task_name = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $task_name, $task_id);

        if ($stmt->execute()) {
            header("Location: index.php"); // Redirect back to the main page
        } else {
            echo "Error updating task.";
        }
    }
} else {
    echo "Task not found.";
}
?>

<form action="edit_task.php?id=<?php echo $task['id']; ?>" method="POST">
    <input type="text" name="task_name" value="<?php echo $task['task_name']; ?>" required>
    <button type="submit">Update Task</button>
</form>
