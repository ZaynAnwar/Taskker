<?php 

    session_start();

    include '../connection.php';

    if(!isset($_SESSION['UID'])){
      $Account_Type = $_SESSION['A_TYPE'];
      if(!$Account_Type == 'Seeker'){
        header('Location: ../login/login.php');
        exit();
      }
      header('Location: ../login/login.php');
      exit;
    }

    $uid = $_SESSION['UID'];

    $userName;
    $userEmail;
    $userGender;

    $sql = "SELECT * FROM `seeker` WHERE `sid` = '".$_SESSION['UID']."'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);
      $userName = $row['name'];
      $userEmail = $row['email'];
      $userGender = $row['gender'];
      $userImage = $row['image'];
      $marketingNotifications = $row['m_notifications'];
    }

    // Sessions 
    $_SESSION['PROFILE_IMAGE'] = $userImage;

    // Task percentage
    $totalTasks = 0;
    $completedTasks = 0;
    $canceledTasks = 0;
    $activeTasks = 0;

    $sql2 = "SELECT * FROM `tasks` WHERE `Creater` = '".$_SESSION['UID']."'";
    $result = mysqli_query($conn, $sql2);
    while($row = mysqli_fetch_assoc($result)){
      $totalTasks++;
      if($row['task_status'] == 'Completed'){
        $completedTasks++;
      } else if($row['task_status'] == 'Cancelled'){
        $canceledTasks++;
      } else if($row['task_status'] == 'Active'){
        $activeTasks++;
      }
    }

    $completedTaskpercentage = 0;
    $canceledTaskPercentage = 0;
    $activeTaskPercentage = 0;
    $completedandActivetasksPercentage = 0;

    if($totalTasks > 0){
      $completedTaskpercentage = ($completedTasks / $totalTasks) * 100;
      $canceledTaskPercentage = ($canceledTasks / $totalTasks) * 100;
      $activeTaskPercentage = ($activeTasks / $totalTasks) * 100;
      $completedandActivetasksPercentage = (($completedTasks + $activeTasks) / $totalTasks ) * 100;
    }


    // Average Rating
    $avgRating;
    $sql3 = "SELECT * FROM `ratings` WHERE `rating_taker` = '".$_SESSION['UID']."'";




?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="cprofile.css" />
  </head>
  <body>
    <div class="client-profile-page">
      <!-- Header -->
      <div class="header">
        <h2>Dashboard</h2>
        
        <div class="info-container">
          <a href="../index.php">Home</a>
          <a href="../post/time_date/post.html">Post Task</a>
          <a href=".././logout.php">Logout</a>
        </div>
        <div class="user-profile">
          <img
            src="../uploads/profiles/<?php echo $userImage ?>"
            alt="../uploads/profiles/<?php echo $userImage ?>"
            class="avatar"
            onclick="toggleProfileEditPopup()"
          />
        </div>
      </div>

      <!-- Main Profile Section -->
      <div class="main-profile-section">
        <div class="left-panel">
          <div class="profile-card">
            <div class="pimage">
              <img src="../uploads/profiles/<?php echo $userImage ?>" alt="<?php echo $userImage ?>" class="profile-image" />
            </div>
            <h3 id="uname"><?php echo $userName ?></h3>
            <button class="appointment-btn"><a href="/post/time_date/post.html">Post New Task</a></button>
            <button class="appointment-btn"><a href="">Update Password</a></button>
            <button class="appointment-btn"><a href="../Chats/chats.php">Chat</a></button>

            <div class="client-details">
              <div class="detail-item">
                <p>Email</p>
                <span id="uemail"><?php echo $userEmail ?></span>
              </div>
              <div class="detail-item">
                <p>Gender</p>
                <span id="ugender"><?php echo $userGender ?></span>
              </div>
              <div class="detail-item">
                <p>Alerts</p>
                <?php 

                     if($marketingNotifications == 'on') {
                        echo "<span class='status booked'>Enabled</span>";
                     } else {
                        echo "<span class='status cancelled'>Disabled</span>";
                     }
                
                ?>
              </div>
            </div>
          </div>
        </div>


        
        <!-- Popup Edit Card next to Avatar -->
        <div id="profile-edit-popup" class="profile-edit-popup">
          <form method="post" action="save-profile-changes.php" enctype="multipart/form-data">
          <h3>Edit Profile</h3>

          <label for="edit-picture">Profile Picture:</label>
          <input
            type="file"
            id="edit-picture"
            accept="image/*"
            name="profileImage"
            onchange="previewPicture(event)"
          />
          <img id="picture-preview" src="client-picture.jpg" />

          <label for="edit-name">Name:</label>
          <input type="text" id="edit-name" name="name" value="<?php echo $userName ?>" />

          <label for="edit-email">Email:</label>
          <input
            type="email"
            id="edit-email"
            name="email"
            value="<?php echo $userEmail ?>"
          />

          <label for="edit-gender">Gender:</label>
          <select id="edit-gender" name="gender">
            <option class="opt" selected hidden value="<?php echo $userGender?>"><?php echo $userGender?></option>
            <option class="opt" value="Female">Female</option>
            <option class="opt" value="Male">Male</option>
            <option class="opt" value="Other">Other</option>
          </select>

          <label for="notifications-toggle"
            >Allow Marketing Notifications:</label
          >
          <?php

             if($marketingNotifications == 'on') {
                echo "<input type='checkbox' name='notifications' id='notifications-toggle' checked />";
             } else {
                echo "<input type='checkbox' name='notifications' id='notifications-toggle' />";
             }

           ?>
          
          <button class="save-profile" onclick="saveProfileChanges()">
            Save Changes
          </button>
        </form>
        </div>

        <div class="right-panel">
          <!-- Stats Section -->
          <div class="stats-section">
            <div class="stat">
              <?php 
                $sql = "SELECT COUNT(task_id) as totalTasks FROM tasks WHERE Creater = '$uid'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo "<h3> " . $row['totalTasks'] . " </h3>";
              ?>
              <p>All Bookings</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: <?php echo $completedandActivetasksPercentage ?>%; background-color: #54604c"
                ></div>
              </div>
              <span> <?php echo $completedandActivetasksPercentage ?>%</span>
            </div>
            <div class="stat">
              <?php 
                $sql = "SELECT COUNT(task_id) as totalTasks FROM tasks WHERE Creater = '$uid' AND task_status = 'Completed'";
                $result = mysqli_query($conn, $sql);

                $row = mysqli_fetch_assoc($result);
                echo "<h3> ". $row['totalTasks']. " </h3>";
              ?>
              <p>Completed</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: <?php echo $completedTaskpercentage ?>%; background-color: #54604c"
                ></div>
              </div>
              <span><?php echo $completedTaskpercentage ?>%</span>
            </div>
            <div class="stat">
            <?php 
                $sql = "SELECT COUNT(task_id) as totalTasks FROM tasks WHERE Creater = '$uid' AND task_status = 'Cancelled'";
                $result = mysqli_query($conn, $sql);

                $row = mysqli_fetch_assoc($result);
                echo "<h3> ". $row['totalTasks']. " </h3>";
              ?>
              <p>Cancelled</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: <?php echo $canceledTaskPercentage ?>%; background-color: #f8d7da"
                ></div>
              </div>
              <span> <?php echo $canceledTaskPercentage?>%</span>
            </div>
          </div>

          <!-- Appointments Section -->
          <div class="appointments-section">
            <div class="tabs">
              <button class="tab active" id="appointmentsTab">History</button>
              <button class="tab" id="invoicesTab">Invoices</button>
            </div>

            <div class="tab-content active" id="appointmentsContent">
            <?php 

              $query = "SELECT * FROM `tasks` WHERE `Creater` = '$uid'";
              $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)){
                $task_id = $row['task_id'];
                $task_title = $row['task_title'];
                $task_description = $row['task_description'];
                $task_status = $row['task_status'];
                $task_price = $row['task_budget'];
                $task_date = $row['task_createdOn'];

                $date = date('d', strtotime($task_date));
                $month = date('M', strtotime($task_date)); 

                $format = $date . ' ' . $month
                
                
                ?>
                
                <div class="appointment-content" id="appointmentsContent">
                  <div class="appointment-item">
                    <p><strong><?php echo $format ?></strong> - <?php echo $task_title ?></p>
                    <div class="itemin">
                      <?php 

                        if($task_status == 'Active') {
                          echo "<span class='status booked'> " . $task_status . "</span>";
                        } else if ($task_status == 'Completed') {
                          echo "<span class='status done'>". $task_status ."</span>";
                        } else if($task_status == 'Cancelled') {
                          echo "<span class='status cancelled'>" . $task_status . "</span>";
                        }
                      
                      ?>
                      <span class="price">RS <?php  echo $task_price ?></span>
                    </div>
                  </div>
                </div>

              <?php }
            } else {
              echo "<h3>No appointments found.</h3>";
            }

              
            ?>
            </div>

            <!-- Invoices Content (Initially Hidden) -->
            <div class="invoice-content hidden" id="invoicesContent">
              <div class="invoice-item">
                <p><strong>Plumbing</strong> - Invoice #12345</p>
                <span class="price">RS 800</span>
              </div>
              <div class="invoice-item">
                <p><strong>Carpentry</strong> - Invoice #67890</p>
                <span class="price">RS 1200</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quotation Section -->
      <div class="quotation-section">
        <h3>Quotations for Your Posted Tasks</h3>

        <?php 

        $sql = "SELECT * FROM tasks WHERE creater = '$uid'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){ 
          while($row = mysqli_fetch_array($result)){?>
            <div class="quotation-up">
              <h4><?php echo $row['task_title'] ?></h4>
              <div class="quotation-in">
                <?php 

                  $query = "SELECT * FROM applied_tasks INNER JOIN `provider` ON applied_tasks.applier_id = `provider`.pid WHERE applied_tasks.task_id = ' " .$row['task_id']. "'";
                  $run = mysqli_query($conn, $query);

                  if(mysqli_num_rows($run) > 0){
                    while($data = mysqli_fetch_array($run)){?>
                      <div class="quotation-container">
                        <div class="quotation-inner">
                          <div class="quotation-header">
                          <div class="provider-info">
                            <span class="provider-name"><?php echo $data['name'] ?></span>
                            <span class="provider-service">Plumbing</span>
                          </div>
                          <div class="provider-rating">
                            <?php 
                              $sql = "SELECT AVG(rating) as avgRating FROM rating WHERE rating_taker = '" . $data['pid'] . "'";
                              $result = mysqli_query($conn, $sql);
                              $innerrow = mysqli_fetch_assoc($result);
                              
                              echo "<span>Rating : ⭐ ". round($innerrow['avgRating'], 1). "</span>";
                            ?>
                          </div>  
                          </div>
                          <div class="quotation-details">
                          <div class="detail">
                            <strong>Availability:</strong> <?php echo $data['availbality'] ?>
                          </div>
                          <div class="detail">
                            <strong>Experience:</strong> <?php echo $data['experience'] ?> Years
                          </div>
                          <div class="detail">
                            <strong>Price Quoted:</strong> <?php echo $row['task_budget'] ?> PKR
                          </div>
                          </div>
                          <div class="quotation-footer">
                          <div class="description">
                            <div class="detail"><strong>Description:</strong></div>
                            <p>
                              <?php echo $row['task_description'] ?>
                            </p>
                          </div>
                          </div>
                        </div> 
                        
                        <div class="quotation-actions">
                          <form action="Review and Rating/review_rating.php" method="post">
                            <input type="hidden" name="provider_id" value="<?php echo $data['pid']?>">
                            <input type="hidden" name="task_id" value="<?php echo $row['task_id']?>">
                            <input type="hidden" name="task_title" value="<?php echo $row['task_title']?>">
                            <input type="submit" name="REVIEW" class="btn hire-btn" value="Review Profile">
                          </form>
                          <button class="btn message-btn">Hire</button>
                          <form action="../Chat system/chat.php" method="post">
                            <input type="hidden" name="provider_id" value="<?php echo $data['pid']?>">
                            <input type="hidden" name="task_id" value="<?php echo $row['task_id']?>">
                            <input type="hidden" name="task_title" value="<?php echo $row['task_title']?>">
                            <input type="submit" name="OPEN_CHAT_C2P" class="btn hire-btn" value="Message">
                          </form>
                        </div>

                      </div>
                    <?php }
                ?>
              </div>
            </div>
          <?php } else {
            echo "<p>No quotes found for this task.</p>";
          }
          }
         } else {
          echo "<p>No tasks found.</p>";
         }
        ?>
      </div>
    </div>

    <script src="cprofile.js"></script>
  </body>
</html>
