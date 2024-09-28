<?php 

    session_start();

    require('../connection.php');

    if(!isset($_SESSION['UID'])){
      header("location: ../login/login.php");
      exit();
    }

    $uid = $_SESSION['UID'];

    $userName;
    $userEmail;
    $userImage;
    $userExperience;

  


    $sql = "SELECT * FROM `provider` WHERE pid = '$uid'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);
      $userName = $row['name'];
      $userEmail = $row['email'];
      $userImage = $row['image'];
      $userExperience = $row['experience'];
      $userLocation = $row['location'];
      $userGender = $row['gender'];
      $userCnic = $row['cnic'];
      $userPhone = $row['phone'];
      $marketingNotifications = $row['m_notifications'];
    }

    // Sessions
    $_SESSION['PROFILE_IMAGE'] = $userImage;


    // Task percentage
    $totalTasks = 0;
    $completedTasks = 0;
    $canceledTasks = 0;
    $appliedTasks = 0;
    $completedAndAppliedTaskPercentage = 0;

    $query = "SELECT * FROM `applied_tasks` WHERE `applier_id` = '$uid'";
    $run = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($run) > 0) {
      while ($row = mysqli_fetch_assoc($run)){
        $totalTasks++;
        if($row['applied_status'] == 'Applied'){
          $appliedTasks++;
        } else if($row['applied_status'] == 'Completed'){
          $completedTasks++;
        } else if($row['applied_status'] == 'Canceled'){
          $canceledTasks++;
        }
      }
    }

    if($totalTasks != 0){
      $completedTaskPercentage = ($completedTasks / $totalTasks) * 100;
      $appliedTaskPercentage = ($appliedTasks / $totalTasks) * 100;
      $canceledTaskPercentage = ($canceledTasks / $totalTasks) * 100;
      $completedAndAppliedTaskPercentage = (($completedTasks + $appliedTasks) / $totalTasks) * 100;
    }

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
    <link rel="stylesheet" href="profile.css" />
  </head>
  <body>
    <div class="client-profile-page">
      <!-- Header -->
      <div class="header">
        <h2>Dashboard</h2>
        <div class="info-container">
          <a href="#">Home</a>
          <a href="../find task/find_task.php">Find Task</a>
          <a href="../logout.php">Logout</a>
        </div>
        <div class="user-profile">
          <img
            src="../uploads/profiles/<?php echo $userImage ?>"
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
              <img src="../uploads/profiles/<?php echo $userImage ?>" class="profile-image" />
            </div>
            <h3><?php echo $userName ?></h3>
            <button class="appointment-btn">Find task</button>

            <div class="client-details">
              <div class="detail-item">
                <p>Location</p>
                <span><?php echo $userLocation ?></span>
              </div>
              <div class="detail-item">
                <p>Gender</p>
                <span><?php echo $userGender ?></span>
              </div>
              <div class="detail-item">
                <p>CNIC</p>
                <span><?php echo $userCnic ?></span>
              </div>
              <div class="detail-item">
                <p>Rating</p>
                <span>4.5/5</span>
              </div>
              <div class="detail-item">
                <p>Experience</p>
                <span> <?php echo $userExperience ?> years</span>
              </div>
              <div class="detail-item">
                <p>Reviews</p>
                <span>25 Reviews</span>
              </div>
              <div class="detail-item">
                <p>Alerts</p>
                <?php 

                  if($marketingNotifications == 'on'){
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
          <form action="save-profile-changes.php" method="post" enctype="multipart/form-data"> 
          <h3>Edit Profile</h3>

          <label for="edit-picture">Profile Picture:</label>
          <input
            type="file"
            id="edit-picture"
            name="profileImage"
            accept="image/*"
            onchange="previewPicture(event)"
          />
          <img id="picture-preview" src="client-picture.jpg" />

          <label for="edit-name">Name:</label>
          <input type="text" id="edit-name" name="name" value="<?php echo $userName ?>" />

          <label for="edit-location">Location</label>
          <input
            type="text"
            id="edit-location"
            name="location"
            value="<?php echo $userLocation ?>"
          />

          <label for="edit-gender">Gender:</label>
          <select id="edit-gender" name="gender">
            <option class="opt" selected hidden value="<?php echo $userGender?>"><?php echo $userGender?></option>
            <option class="opt" value="Male" selected>Male</option>
            <option class="opt" value="Female">Female</option>
            <option class="opt" value="Other">Other</option>
          </select>

          <label for="edit-cnic">CNIC</label>
          <input type="text" id="edit-cnic" name="cnic" value="<?php echo $userCnic ?>" />

          <label for="edit-experience">Experience (Years)</label>
          <input type="number" id="edit-experience" name="experience" value="<?php echo $userExperience ?>" />

          <h4>Update Password</h4>
          <label for="enter-password">Enter Password</label>
          <input type="text">
          <label for="re-enter-password">Re-enter Password</label>
          <input type="text">

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

          <button type="submit" class="save-profile">
            Save Changes
          </button>
          </form>
        </div>

        <div class="right-panel">
          <!-- Stats Section -->
          <div class="stats-section">
            <div class="stat">
              <h3><?php echo ($completedTasks + $appliedTasks) ?></h3>
              <p>All Bookings</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: <?php echo $completedAndAppliedTaskPercentage ?>%; background-color: #14a800e5"
                ></div>
              </div>
              <span><?php echo $completedAndAppliedTaskPercentage ?>%</span>
            </div>
            <div class="stat">
              <h3><?php echo $completedTasks ?></h3>
              <p>Completed</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: <?php echo $completedTasks ?>%; background-color: #54604c"
                ></div>
              </div>
              <span><?php echo $completedTasks ?>%</span>
            </div>
            <div class="stat">
              <h3><?php echo $canceledTasks ?></h3>
              <p>Cancelled</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: <?php echo $canceledTasks ?>%; background-color: #f8d7da"
                ></div>
              </div>
              <span><?php echo $canceledTasks ?>%</span>
            </div>
          </div>

          <!-- Appointments Section -->
          <div class="appointments-section">
            <div class="tabs">
              <button class="tab active" id="appointmentsTab">History</button>
              <button class="tab" id="invoicesTab">Invoices</button>
            </div>

            <!-- Appointments Content -->
            <div class="appointment-content" id="appointmentsContent">
              <?php 

                $taskTitle;
                $taskBudget;

                $query = "SELECT * FROM applied_tasks INNER JOIN tasks ON applied_tasks.task_id = tasks.task_id WHERE applier_id = '$uid'";
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)){

                    ?>
                    
                    <div class="appointment-item">
                      <p><strong><?php echo date('d M', strtotime($row['applied_on'])) ?></strong> - <?php echo $row['task_title'] ?></p>
                      <div class="itemin">
                        <?php 
                          if($row['applied_status'] == 'Applied'){
                            echo "<span class='status booked'>". $row['applied_status']."</span>";
                          } else if($row['applied_status'] == 'Completed'){ 
                            echo "<span class='status done'> ". $row['applied_status'] ."</span>";
                          } else if($row['applied_status'] == 'Cancelled'){
                            echo "<span class='status cancelled'>".$row['applied_status']."</span>";
                          }
                        ?>
                        <span class="price">RS <?php echo $row['task_budget'] ?></span>
                      </div>
                    </div>
                  <?php }
                } else {
                  echo "<p style='display: flex; justify-content: center; align-items:center; height: 100vh;'>No appointments found. <a href='../find task/find_task.php'>Find a task</a></p>";
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

          <!-- Review Carousel Section -->
          <div class="review-carousel-section">
            <h3>Customer Reviews</h3>
            <div class="review-carousel-container">
              <div class="review-carousel" id="reviewCarousel">
                <?php  
                  $query = "SELECT * FROM `reviews` INNER JOIN seeker ON reviews.review_giver = seeker.sid WHERE `review_taker` = '$uid'";
                  $result = mysqli_query($conn, $query);

                  if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)){
                      echo "<div class='review-tile'>
                          <p><q>".$row['review_description']."</q></p>
                          <span>- ".$row['name']."</span>
                        </div>";
                    }
                  }
                ?>
                <div class="review-tile">
                  <p>"Excellent service, very professional!"</p>
                  <span>- Ahmed Khan</span>
                </div>
                <div class="review-tile">
                  <p>"Great experience, highly recommend!"</p>
                  <span>- Sara Ali</span>
                </div>
                <div class="review-tile">
                  <p>"Good job done on time. Will hire again!"</p>
                  <span>- Asim Malik</span>
                </div>
                <div class="review-tile">
                  <p>"Very satisfied with the quality of work."</p>
                  <span>- Fatima Rizwan</span>
                </div>
                <div class="review-tile">
                  <p>"Efficient and polite, great service."</p>
                  <span>- Waqar Shah</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="profile.js"></script>
  </body>
</html>
