<?php 

    session_start();

    include '../../connection.php';


    if(isset($_POST['REVIEW'])){
        $task_id = $_POST['task_id'];
        $provider_id = $_POST['provider_id'];
    }

    $sql = "SELECT * FROM tasks WHERE task_id  = '$task_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $task_status = $row['task_status'];
    $task_description = $row['task_description'];

    $sql2 = "SELECT * FROM applied_tasks WHERE task_id = '$task_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $provider = $row2['applier_id'];

    $sql3 = "SELECT * FROM rating WHERE task_id = '$task_id' AND rating_taker = '$provider_id'";
    $result3 = mysqli_query($conn, $sql3);
    $rating;
    if(mysqli_num_rows($result3) > 0){
        $row3 = mysqli_fetch_assoc($result3);
        $rating = $row3['rating'];
    } else {
        $rating = 0;
    }

    $sql4 = "SELECT * FROM reviews WHERE task_id = '$task_id' AND review_taker = '$provider'";
    $result4 = mysqli_query($conn, $sql4);
    $review;
    if(mysqli_num_rows($result4) > 0){
        $row4 = mysqli_fetch_assoc($result4);
        $review = $row4['review_description'];
    } else {
        $review = "";
    }
    
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review & Rating | Taskker</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="review_rating.css">
</head>
<body>
    <div class="container">
        <!-- Status Section -->
        <div class="section status-section">
            <h2>Task Status: <span class="status"><?php echo $task_status ?></span></h2>
        </div>

        <!-- Task Details Section -->
        <div class="section task-details">
            <h2>Task Details</h2>
            <p><strong>Service:</strong> Plumbing</p>
            <p><strong>Date:</strong> 12th August 2024</p>
            <p><strong>Description:</strong> <?php echo $task_description ?></p>
        </div>

        <!-- Provider Profile Button -->
        <div class="section provider-profile">
            <button class="profile-btn">View Provider Profile</button>
        </div>

        <!-- Review and Rating Section -->
        <div class="section review-section">
            <h2>Leave Your Review</h2>
            <div class="rating-wrapper">
                <label for="rating">Rate Your Experience:</label>
                <div class="rating-stars" id="rating-stars">
                    <!--- Fill stars according to $rating --->
                    <?php
                        if($rating != 0){
                            for($i = 1; $i <= 5; $i++){
                                if($i <= $rating){
                                   ?>
                                    <i class="ri-star-line active"data-value="<?php echo $i?>"></i>
                                    <?php
                                } else {
                                   ?>
                                    <i class="ri-star-line" data-value="<?php echo $i?>"></i>
                                    <?php
                                }
                            }
                        } else {
                            for($i = 1; $i <= 5; $i++){
                               ?>
                                    <i class="ri-star-line" data-value="<?php echo $i?>"></i>
                                    <?php
                            }
                        }
                        
                    
                    ?>
                    
                </div>
            </div>
            <?php 
            
            if(!empty($review)){?>
                <textarea id="reviewText" placeholder="Write your review here..."><?php echo $review ?></textarea>
            <?php } else { ?>
                <textarea id="reviewText" placeholder="Write your review here..."></textarea>
             <?php }   
            
            ?>
            
            <button class="submit-review" id="submitReviewBtn">Submit Review</button>
        </div>
    </div>

    <script>
        const taskId = '<?php echo $task_id ?>';
        const clientId = '<?php echo $_SESSION['UID'] ?>';
        const providerID = '<?php echo $provider ?>';
    </script>
    <script src="review_rating.js"></script>
</body>
</html>
