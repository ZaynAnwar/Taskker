<?php 

    include '../../connection.php';

    $taskId = $_POST['task_id'];

    $sql = "SELECT * FROM tasks WHERE task_id = '$taskId'";
    $result  = mysqli_query($conn, $sql);

    $date;

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $taskTitle = $row['task_title'];
        //$taskCategory = $row['task_category'];
        $taskCity = $row['task_city'];
        $taskDescription = $row['task_description'];
        $taskBudget = $row['task_budget'];
        $task_onDate = $row['task_onDate'];
        $task_beforeDate = $row['task_beforeDate'];
        
    }

   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details | Taskker</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="details.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="main-header">
            <h1>Task Details</h1>
            <a href="../find_task.php" class="back-link"><i class="ri-arrow-left-line"></i> Back to Tasks</a>
        </header>

        <!-- Task Details Section -->
        <section class="task-details">
            <div class="task-info">
                <h2 id="taskTitle"> <?php echo $taskTitle ?></h2>
                <!--- <p id="taskCategory">Category: <strong></strong></p> -->
                <p id="taskLocation">Location: <strong><?php echo $taskCity ?></strong></p>
                <?php
                if(!empty($task_onDate) && $task_onDate != '0000-00-00' ){
                    $date = date('d-m-Y', strtotime($task_onDate) );
                    echo "<p>On Date: <strong>". $date ."</strong><p/>";
                } else if(!empty($task_beforeDate) && $task_beforeDate != '0000-00-00'){
                    $date = date('d-m-Y', strtotime($task_beforeDate));
                    echo "<p>Before Date: <strong>". $date ."</strong><p/>";
                } else {
                    $date = "Flexible";
                    echo "<p> Flexible <p/>";
                }
                ?>
                <p id="taskPrice">Price: <strong> <?php echo $taskBudget ?> </strong></p>
            </div>

            <div class="task-description">
                <h3>Description</h3>
                <p id="taskDescription">
                    <?php echo $taskDescription ?>
                </p>
            </div>

            <!-- Provider Details Section -->
            <section class="provider-details">
                <h3>Service Provider</h3>
                <div class="provider-info">
                    <img src="provider-avatar.jpg" class="provider-avatar" alt="Provider Avatar">
                    <div class="provider-info-text">
                        <p><strong>John Doe</strong></p>
                        <p>Rating: <span class="rating">4.8/5</span></p>
                        <p>Experience: 5 years</p>
                        <p>Availability: Mon-Fri, 9 AM - 6 PM</p>
                    </div>
                </div>
                <div class="provider-actions">
                    <button class="message-btn"><a href="/Taskker website/chat system/chat.html">Chat With Client</a></button>
                    <button class="hire-btn">Apply Now</button>
                </div>
            </section>
        </section>
    </div>

    <script src="details.js"></script>
</body>
</html>
