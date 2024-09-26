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
    <link rel="stylesheet" href="profile.css" />
  </head>
  <body>
    <div class="client-profile-page">
      <!-- Header -->
      <div class="header">
        <h2>Provider Profile</h2>
        <div class="info-container">
          <a href="#">Home</a>
          <a href="../find task/find task.html">Find Task</a>
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
                <span>Satellatown, Bahawalpur</span>
              </div>
              <div class="detail-item">
                <p>Gender</p>
                <span>Male</span>
              </div>
              <div class="detail-item">
                <p>CNIC</p>
                <span>35201-1234567-9</span>
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
                <span>Allows Marketing Notifications</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Popup Edit Card next to Avatar -->
        <div id="profile-edit-popup" class="profile-edit-popup">
          <h3>Edit Profile</h3>

          <label for="edit-picture">Profile Picture:</label>
          <input
            type="file"
            id="edit-picture"
            accept="image/*"
            onchange="previewPicture(event)"
          />
          <img id="picture-preview" src="client-picture.jpg" />

          <label for="edit-name">Name:</label>
          <input type="text" id="edit-name" value="John Robert" />

          <label for="edit-location">Location</label>
          <input
            type="text"
            id="edit-location"
            value="Satellatown, Bahawalpur"
          />

          <label for="edit-gender">Gender:</label>
          <select id="edit-gender">
            <option class="opt" value="Male" selected>Male</option>
            <option class="opt" value="Female">Female</option>
            <option class="opt" value="Other">Other</option>
          </select>

          <label for="edit-cnic">CNIC</label>
          <input type="text" id="edit-cnic" value="35201-1234567-9" />

          <label for="edit-rating">Rating</label>
          <input type="number" id="edit-rating" value="4.5" />

          <label for="edit-experience">Experience (Years)</label>
          <input type="number" id="edit-experience" value="5" />

          <label for="edit-reviews">Reviews</label>
          <input type="number" id="edit-reviews" value="25" />

          <label for="notifications-toggle"
            >Allow Marketing Notifications:</label
          >
          <input type="checkbox" id="notifications-toggle" checked />

          <button class="save-profile" onclick="saveProfileChanges()">
            Save Changes
          </button>
        </div>

        <div class="right-panel">
          <!-- Stats Section -->
          <div class="stats-section">
            <div class="stat">
              <h3>4</h3>
              <p>All Bookings</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: 75%; background-color: #14a800e5"
                ></div>
              </div>
              <span>75%</span>
            </div>
            <div class="stat">
              <h3>1</h3>
              <p>Completed</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: 25%; background-color: #54604c"
                ></div>
              </div>
              <span>25%</span>
            </div>
            <div class="stat">
              <h3>1</h3>
              <p>Cancelled</p>
              <div class="progress-bar">
                <div
                  class="progress"
                  style="width: 25%; background-color: #f8d7da"
                ></div>
              </div>
              <span>25%</span>
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
              <div class="appointment-item">
                <p><strong>29 Sep</strong> - Plumbing</p>
                <div class="itemin">
                  <span class="status cancelled">Cancelled</span>
                  <span class="price">RS 1500</span>
                </div>
              </div>
              <div class="appointment-item">
                <p><strong>15 Oct</strong> - Carpentry</p>
                <div class="itemin">
                  <span class="status booked">Booked</span>
                  <span class="price">RS 2000</span>
                </div>
              </div>
              <div class="appointment-item">
                <p><strong>13 Apr</strong> - Gardening</p>
                <div class="itemin">
                  <span class="status done">Done</span>
                  <span class="price">RS 500</span>
                </div>
              </div>
              <div class="appointment-item">
                <p><strong>24 Feb</strong> - Blue Print Structure</p>
                <div class="itemin">
                  <span class="status booked">Booked</span>
                  <span class="price">RS 3000</span>
                </div>
              </div>
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

    <script src="/Profile/profile.js"></script>
  </body>
</html>
