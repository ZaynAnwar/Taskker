<?php

session_start();
  $uid = $_SESSION['UID'];
  $userType = $_SESSION['A_TYPE'];

  include '../connection.php';



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Taskker | Chat</title>
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="chats.css" />
  </head>
  <body>
    <div class="chat-container">
      <!-- Chat List Section (Sidebar) -->
      <aside class="chat-list">
        <!-- Search Bar in Sidebar -->
        <div class="chat-search-bar">
            <input type="text" id="searchUser" placeholder="Search users...">
            <i class="ri-search-line search-icon"></i>

        </div>

        <!-- User List -->
        <?php

          $sql = "SELECT * FROM chat WHERE member_1 = '$uid' OR member_2 = '$uid'";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
              $member1 = $row['member_1'];
              $member2 = $row['member_2'];
              
              // My task is to actually show the user that is not me, we should also check usertype to know if the user is a client or a provider
              if($userType == 'Seeker'){
                if($member1 == $uid){
                  $sql2 = "SELECT * FROM `provider` WHERE pid = '$member2'";
                  $result2 = mysqli_query($conn, $sql2);
                  if(mysqli_num_rows($result2) > 0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                      $userName = $row2['name'];
                      $userAvatar = $row2['image'];
                      $userId = $member2;
                      echo '<ul id="chatUserList">
                              <li class="chat-item" data-userId='.$userId.' data-userName='.$userName.' data-acType="Provider">
                                <img src="../uploads/profiles/'. $userAvatar .'" alt="../uploads/profiles/'. $userAvatar .'" class="user-avatar" />
                                <span>'.$userName.'</span>
                              </li>
                            </ul>';

                    }
                  }
                } else if($member2 == $uid){
                  $sql2 = "SELECT * FROM `provider` WHERE pid = '$member1'";
                  $result2 = mysqli_query($conn, $sql2);
                  if(mysqli_num_rows($result2) > 0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                      $userName = $row2['name'];
                      $userAvatar = $row2['image'];
                      $userId = $member1;
                      echo '<ul id="chatUserList">
                              <li class="chat-item" data-userId='.$userId.' data-userName='.$userName.' data-acType="Provider">
                                <img src="../uploads/profiles/'. $userAvatar .'" alt="../uploads/profiles/'. $userAvatar .'" class="user-avatar" />
                                <span>'.$userName.'</span>
                              </li>
                            </ul>';
                    }
                  }
                }
              } else if($userType == 'Provider'){
                if($member1 == $uid){
                  $sql2 = "SELECT * FROM `seeker` WHERE `sid` = '$member2'";
                  $result2 = mysqli_query($conn, $sql2);
                  if(mysqli_num_rows($result2) > 0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                      $userName = $row2['name'];
                      $userAvatar = $row2['image'];
                      $userId = $member2;
                      echo '<ul id="chatUserList">
                              <li class="chat-item" data-userId='.$userId.' data-userName='.$userName.' data-acType="Seeker">
                                <img src="../uploads/profiles/'. $userAvatar .'" alt="../uploads/profiles/'. $userAvatar .'" class="user-avatar" />
                                <span>'.$userName.'</span>
                              </li>
                            </ul>';
                    }
                  }
                } else if($member2 == $uid){
                  $sql2 = "SELECT * FROM `seeker` WHERE `sid` = '$member1'";
                  $result2 = mysqli_query($conn, $sql2);
                  if(mysqli_num_rows($result2) > 0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                      $userName = $row2['name'];
                      $userAvatar = $row2['image'];
                      $userId = $member1;
                      echo '<ul id="chatUserList">
                              <li class="chat-item" data-userId='.$userId.' data-userName='.$userName.' data-acType="Seeker">
                                <img src="../uploads/profiles/'. $userAvatar .'" alt="../uploads/profiles/'. $userAvatar .'" class="user-avatar" />
                                <span>'.$userName.'</span>
                              </li>
                            </ul>';
                    }
                  }
                }
              }
            }
          }

        ?>
      </aside>

      <!-- Chat Box Section -->
      <div class="chat-box">
        <!-- Chat Header -->
        <header class="chat-header">
          <div class="user-info">
            <img src="user-avatar.jpg" class="avatar" id="chatUserAvatar" alt="User Avatar" />
            <div class="user-details">
              <h3 id="chatUserName">John Robert</h3>
              <p>Online</p>
            </div>
          </div>
          <button class="back-btn">
            <i class="ri-arrow-left-line"></i> Back to Conversations
          </button>
        </header>

        <!-- Chat Messages Section -->
        <div class="chat-window" id="chatWindow">
          <div class="message received">
            <p class="message-text">
              Hi, can we schedule the task for tomorrow?
            </p>
            <span class="message-time">10:30 AM</span>
          </div>
          <div class="message sent">
            <p class="message-text">Yes, that works for me. What time?</p>
            <span class="message-time">10:32 AM</span>
          </div>
        </div>

        <!-- Chat Input Section -->
        <div class="chat-input">
          <input
            type="text"
            id="messageInput"
            placeholder="Type your message..."
          />
          <!-- File Input for sending images/videos -->
          <label for="mediaInput" class="file-label">
            <i class="ri-attachment-line"></i>
          </label>
          <input
            type="file"
            id="mediaInput"
            accept="image/*, video/*"
            style="display: none"
          />

          <!-- Button for recording voice messages -->
          <button id="recordVoiceBtn" class="voice-btn">
            <i class="ri-mic-line"></i>
          </button>

          <!-- Button for sending text message -->
          <button id="sendMessageBtn">
            <i class="ri-send-plane-2-fill"></i>
          </button>
        </div>
      </div>
    </div>

    <script>
        let myId = <?php echo $_SESSION['UID'] ?>
    </script>
    <script src="chats.js"></script>
  </body>
</html>
