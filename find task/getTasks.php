<?php

session_start();
require ('../connection.php');

// Sessions
$uid  = $_SESSION['UID'];

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
        $isTaskApplied = false;
        $query = "SELECT applied_status FROM `applied_tasks` WHERE applier_id = '$uid' AND task_id = " . $row['task_id'];
        $run = mysqli_query($conn, $query);
        if (mysqli_num_rows($run) > 0) {
            $rowTask = mysqli_fetch_assoc($run);
            $isTaskApplied = $rowTask['applied_status'] == 'Applied'? true : false;
        }
        $taskListings .= "
        <div class='task-item'>
            <div class='task-info'>
                <h3>" . htmlspecialchars($row['task_title']) . "</h3> 
                <p>Location: " . htmlspecialchars($row['task_city']) . "</p> 
                <p>Date: " . htmlspecialchars($row['task_createdOn']) . "</p> 
            </div>
            <div class='task-actions'>
                <form action='details/details.php' method='post'>
                    <input type='hidden' name='task_id' value='". htmlspecialchars($row['task_id']) . "' />
                    <input type='submit' class='details-btn' name='TASK_DETAIL' value='Details' />
                </form>
                ". ($isTaskApplied ? "<p>Already Applied</p>" : "<form onsubmit='apply(" . $row['task_id'] . "); return false;'><input type='submit' class='apply-btn' id='btn_". $row['task_id'] ."' name='TASK_APPLY' value='Apply' /></form>") . "
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
