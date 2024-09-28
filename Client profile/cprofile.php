<?php 

    session_start();

    include '../connection.php';

    if(!isset($_SESSION['UID'])){
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

    $sql = "SELECT * FROM `tasks` WHERE `Creater` = '".$_SESSION['UID']."'";
    $result = mysqli_query($conn, $sql);
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

    $completedTaskpercentage = ($completedTasks / $totalTasks) * 100;
    $canceledTaskPercentage = ($canceledTasks / $totalTasks) * 100;
    $activeTaskPercentage = ($activeTasks / $totalTasks) * 100;
    $completedandActivetasksPercentage = (($completedTasks + $activeTasks) / $totalTasks ) * 100;


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
          <a href="../post/time & date/post.html">Post Task</a>
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
            <button class="appointment-btn">Post new task</button>

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

          <h4>Update Password</h4>
          <label for="enter-password">Enter Password</label>
          <input type="text">
          <label for="re-enter-password">Re-enter Password</label>
          <input type="text">
          
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

        <div class="quotation-up">
          <!-- Quotation Container 1 -->
          <div class="quotation-container">
            <div class="quotation-header">
              <div class="provider-info">
                <span class="provider-name">John Doe</span>
                <span class="provider-service">Plumbing</span>
              </div>
              <div class="provider-rating">
                <span>Rating : ⭐ 4.5</span>
              </div>
            </div>
            <div class="quotation-details">
              <div class="detail">
                <strong>Availability:</strong> Monday to Friday
              </div>
              <div class="detail"><strong>Experience:</strong> 5 Years</div>
              <div class="detail"><strong>Price Quoted:</strong> 5,000 PKR</div>
            </div>
            <div class="quotation-footer">
              <div class="description">
                <div class="detail"><strong>Description:</strong></div>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                  non risus. Suspendisse lectus tortor, dignissim sit amet,
                  adipiscing nec, ultricies sed, dolor. Lorem ipsum dolor sit
                  amet, consectetur adipiscing elit. Sed non risus. Suspendisse
                  lectus tortor, dignissim sit amet, adipiscing nec, ultricies
                  sed, dolor.Lorem ipsum dolor sit amet, consectetur adipiscing
                  elit. Sed non risus. Suspendisse lectus tortor, dignissim sit
                  amet, adipiscing nec, ultricies sed, dolor. dolor.Lorem ipsum
                  dolor sit amet, consectetur adipiscing elit. Sed non risus.
                  Suspendisse lectus tortor, dignissim sit amet, adipiscing nec,
                  ultricies sed, dolor.
                </p>
              </div>
              <div class="quotation-actions">
                <button class="btn hire-btn">Hire</button>
                <button class="btn message-btn">Message</button>
              </div>
            </div>
          </div>

          <!-- Quotation Container 2 -->
          <div class="quotation-container">
            <div class="quotation-header">
              <div class="provider-info">
                <span class="provider-name">Sarah Smith</span>
                <span class="provider-service">Electrical Work</span>
              </div>
              <div class="provider-rating">
                <span>Rating : ⭐ 4.8</span>
              </div>
            </div>
            <div class="quotation-details">
              <div class="detail"><strong>Availability:</strong> Weekends</div>
              <div class="detail"><strong>Experience:</strong> 7 Years</div>
              <div class="detail"><strong>Price Quoted:</strong> 7,500 PKR</div>
            </div>

            <div class="quotation-footer">
              <div class="description">
                <div class="detail"><strong>Description:</strong></div>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                  non risus. Suspendisse lectus tortor, dignissim sit amet,
                  adipiscing nec, ultricies sed, dolor. Lorem ipsum dolor sit
                  amet, consectetur adipiscing elit. Sed non risus. Suspendisse
                  lectus tortor, dignissim sit amet, adipiscing nec, ultricies
                  sed, dolor.Lorem ipsum dolor sit amet, consectetur adipiscing
                  elit. Sed non risus. Suspendisse lectus tortor, dignissim sit
                  amet, adipiscing nec, ultricies sed, dolor. dolor.Lorem ipsum
                  dolor sit amet, consectetur adipiscing elit. Sed non risus.
                  Suspendisse lectus tortor, dignissim sit amet, adipiscing nec,
                  ultricies sed, dolor.
                </p>
              </div>
              <div class="quotation-actions">
                <button class="btn hire-btn">Hire</button>
                <button class="btn message-btn">Message</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="cprofile.js"></script>
  </body>
</html>
