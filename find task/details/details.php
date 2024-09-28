<?php 

    session_start();

    include '../../connection.php';



    $uid = $_SESSION['UID'];
    $profileImage = $_SESSION['PROFILE_IMAGE'];

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

                    <img src="../../uploads/profiles/<?php echo $profileImage ?>" class="provider-avatar" alt="Provider Avatar">
                    <div class="provider-info-text">
                        <?php 
                            $sql = "SELECT * FROM `provider` WHERE `pid` = '$uid' ";
                            $result = mysqli_query($conn, $sql);

                            if(mysqli_num_rows($result) > 0){
                                $row = mysqli_fetch_assoc($result);
                                echo "<p>Name: <strong>". $row['name']. "</strong></p>";
                                echo "<p>Rating: <strong> 4.5 </strong></p>";
                                echo "<p>Experience: <strong>". $row['experience']. "</strong></p>";
                                echo "<p>Availability: ". $row['availbality'] ."</p>";
                            }
                        ?>
                    </div>
                </div>
                <div class="provider-actions">
                    <form action="../../Chat system/chat.php" method="post">
                        <?php 
                            $query = "SELECT Creater FROM tasks WHERE task_id = '$taskId' " ;
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            $creater = $row['Creater'];
                            echo "<input type='hidden' name='client_id' value='". $creater. "'>";
                            echo "<input type='hidden' name='task_id' value='". $taskId. "'>";
                            echo "<input type='submit' class='message-btn' name='OPEN_CHAT_P2C' value='Chat with Client'  />"
                        ?>
                        <input type="hidden" >
                    </form>
                    <?php 
                        $sql = "SELECT * FROM applied_tasks WHERE task_id = '$taskId'";
                        $result = mysqli_query($conn, $sql);
                        
                        if(mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_assoc($result);
                            if($row['applied_status'] == 'Applied'){
                                echo "<p>Applied</p>";
                            }
                        } else {
                            echo "<form onsubmit='apply(". $taskId. "); return false;'>
                                    <input class='hire-btn' type='submit' value='Apply' id='tsk'/>
                                </form>";
                        }
                    ?>
                </div>
            </section>
        </section>
    </div>

    <script src="details.js"></script>

    <script>
        function apply(taskId) { 
            event.preventDefault();
            // Perform AJAX request to apply for the task
            $.ajax({
                url: "../apply.php",
                type: "POST",
                data: { taskId: taskId },
                success: function(response) {
                    let element = document.getElementById("tsk");

                    
                    if (element) {
                        element.outerHTML = "<p>Applied</p>";
                    } else {
                        console.error("Element not found for taskId:", taskId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                }
            });
        }
    </script>
    
    <script>

    </script>
</body>
</html>
