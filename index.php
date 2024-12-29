<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

include('db.php');

// Fetch tasks for the logged-in user
$sql = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']); // Bind user ID to the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </header>
        
        <!-- Form to add tasks -->
        <div class="form-container">
            <form action="add_task.php" method="POST">
                <input type="text" name="task_name" placeholder="Enter a new task" required>
                <button type="submit">Add Task</button>
            </form>
        </div>
        
        <!-- Task List -->
        <div class="task-list">
            <h2>Your Tasks</h2>
            <ul>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li class='" . ($row['status'] == 'completed' ? 'completed' : '') . "'>";
                        echo "<span>" . $row['task_name'] . "</span>";
                        echo "<div class='task-actions'>";
                        echo " <a href='edit_task.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>";
                        echo " <a href='delete_task.php?id=" . $row['id'] . "' class='delete-btn'>Delete</a>";
                        echo " <a href='mark_completed.php?id=" . $row['id'] . "' class='complete-btn'>Mark as Completed</a>";
                        echo "</div>";
                        echo "</li>";
                    }
                } else {
                    echo "<li>No tasks found.</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>

