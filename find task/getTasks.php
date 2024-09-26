<?php

require ('../connection.php');

$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';

// Format date in YYYY-MM-DD format
$date = date('Y-m-d', strtotime($date));

// Start building the query
$query = "SELECT * FROM tasks WHERE 1=1"; // Use 1=1 for easier appending of conditions
$params = [];
$types = ""; // String to hold types for binding parameters

// Adding conditions based on user inputs
if (!empty($searchTerm)) {
    $query .= " AND task_title LIKE ?";
    $params[] = "%" . $searchTerm . "%";
    $types .= "s"; // 's' indicates string
}

if (!empty($category) && $category != 'All') {
    $query .= " AND task_title LIKE ?";
    $params[] = "%" . $category . "%";
    $types .= "s"; // 's' indicates string
}

if (!empty($location)) {
    $query .= " AND task_city = ?";
    $params[] = $location;
    $types .= "s"; // 's' indicates string
}

if (!empty($date) && $date != '1970-01-01') {
    $query .= " AND task_createdOn = ?";
    $params[] = $date; // Using the date variable directly
    $types .= "s"; // 's' indicates string
}

// Prepare the statement
$stmt = mysqli_prepare($conn, $query);

// Bind parameters
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $taskListings = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $taskListings .= "
        <div class='task-item'>
            <div class='task-info'>
                <h3>" . htmlspecialchars($row['task_title']) . "</h3> 
                <p>Location: " . htmlspecialchars($row['task_city']) . "</p> 
                <p>Date: " . htmlspecialchars($row['task_createdOn']) . "</p> 
            </div>
            <div class='task-actions'>
                <form method='post' action=''>
                    <input type='hidden' name='taskId' value='". htmlspecialchars($row['task_id']) . "' />
                    <input type='submit' class='details-btn' name='TASK_DETAIL' value='Details' />
                </form>
                <form method='post' action=''>
                    <input type='hidden' name='taskID' value='". htmlspecialchars($row['task_id']) . "' />
                    <input type='submit' class='apply-btn' name='TASK_APPLY' value='Apply' />
                </form>
            </div>
        </div>
        ";
    }
    echo $taskListings;
} else {
    echo "No tasks found."; 
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
