<?php 
  session_start();

  if(isset($_SESSION['UID'])){
    $type = $_SESSION['A_TYPE'];

    if($type == 'Provider'){
      header("location: Profile/profile.php");
    } else if($type == 'Seeker'){
      header("location: Client profile/cprofile.php");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Taskker.com</title>
    <link rel="icon" type="image/x-icon" href="c1.jpg" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="page1">
      <div class="nav">
        <div class="right">
          <img src="c1.jpg" alt="" />
        </div>
        <div class="menu-icon">
          <i class="ri-menu-line"></i>
        </div>
        <div class="left">
          <div class="category-dropdown">
            <a href="#" class="category-link">Category</a>
            <div class="dropdown-content">
              <a href="#electricians">Electricians</a>
              <a href="#plumbers">Plumbers</a>
              <a href="#painters">Painters</a>
              <a href="#gardeners">Gardeners</a>
            </div>
          </div>
          
          <a href="find task/find task.html" target="">Find Task</a>
          <a href="become tasker/becometskr.html" target="">Become A Tasker</a>
          <a href="login/login.php" target="">Login/Sign Up</a>
        </div>
      </div>
      <div class="overlay"></div>
      <div class="sidebar">
        <div class="close-btn">&times;</div>
        <div class="sidebar-content">
          <div class="category-dropdown">
            <a href="#" class="category-link">Category</a>
            <div class="dropdown-content">
              <a href="#electricians">Electricians</a>
              <a href="#plumbers">Plumbers</a>
              <a href="#painters">Painters</a>
              <a href="#gardeners">Gardeners</a>
            </div>
          </div>
          <a href="find task/find task.html" target="">Find Task</a>
          <a href="become tasker/becometskr.html" target="">Become A Tasker</a>
          <a href="login/login.php" target="">Login/Sign Up</a>
        </div>
      </div>
      <div class="hero">
        <div class="first">
          <div class="title">
            <h1>Find <span class="typ"></span></h1>
            <h1>While Staying At Your Home</h1>
          </div>
          <div class="des">
            <h4>We are bringing you all type of Service</h4>
            <h4>providers just a click away</h4>
          </div>
          <button>
            <a href="post/time & date/post.html" target="#">Post A Task</a>
          </button>
        </div>
        <div class="sec">
          <img src="globe@2x.webp" alt="" />
        </div>
      </div>
    </div>
    <div class="page2">
      <div class="right">
        <div class="box box1">
          <div class="boxin">
            <i class="ri-calendar-check-line"></i>
            <h1>Title & Date</h1>
          </div>
          <p>
            Kickstart your task by giving it a clear title and setting the
            deadline. Whether it's a quick job or a long-term project, defining
            the timeline.
          </p>
        </div>
        <div class="box box2">
          <div class="boxin">
            <i class="ri-user-location-line"></i>
            <h1>Location</h1>
          </div>
          <p>
            From home services to local assistance, providing the location
            ensures that you connect with service providers who are ready to
            work in your area.
          </p>
        </div>
        <div class="box box3">
          <div class="boxin">
            <i class="ri-article-line"></i>
            <h1>Details</h1>
          </div>
          <p>
            Dive deeper into the specifications of your task. Share important
            details, preferences, and any additional information
          </p>
        </div>
        <div class="box box4">
          <div class="boxin">
            <i class="ri-hand-coin-line"></i>
            <h1>Budget</h1>
          </div>
          <p>
            Set the appropriate budget for your task. Indicate the amount you're
            willing to pay, giving service providers a clear understanding of
            your expectations.
          </p>
        </div>
      </div>
      <div class="left">
        <h1>Post your first task in few steps</h1>
        <button><a href="" target="#">Post A Task Right Now</a></button>
      </div>
    </div>
    <div class="page3">
      <div class="up">
        <h1>Browse a task by category</h1>
      </div>
      <div class="down">
        <div class="box bpx1">
          <h1>Electrician</h1>
          <p>
            Power up your projects with skilled electricians. Professionals
            ready to light up your space with expertise in installations,
            repairs, and more.
          </p>
        </div>
        <div class="box bpx2">
          <h1>Plumber</h1>
          <p>
            Dive into plumbing excellence with plumbers. From leaky faucets to
            intricate projects, these experts have your plumbing needs covered.
          </p>
        </div>
        <!-- <div class="box bpx3">
          <h1>Mechanic</h1>
          <p>
            Hit the road with confidence! Mechanics at your service for routine
            maintenance, repairs, and keeping your vehicle in top-notch
            condition.
          </p>
        </div> -->
        <div class="box bpx4">
          <h1>Painter</h1>
          <p>
            Transform your spaces with the strokes of Painters. Creative
            artisans ready to breathe life and color into your home or
            workplace.
          </p>
        </div>
        <div class="box bpx5">
          <h1>Gardner</h1>
          <p>
            Nature's touch in your hands! Gardeners bring expertise to nurture
            your plants, design landscapes, and cultivate the beauty of your
            outdoor spaces.
          </p>
        </div>
        <!-- <div class="box bpx6">
          <h1>Cleaner</h1>
          <p>
            Cleanliness perfected by Cleaning professionals. From homes to
            offices, these experts ensure every nook and cranny is spotless and
            pristine.
          </p>
        </div>
        <div class="box bpx7">
          <h1>Welder</h1>
          <p>
            Crafting strength with Welders. These skilled professionals bring
            precision and durability to every metalwork project.
          </p>
        </div>
        <div class="box bpx8">
          <h1>Others</h1>
          <p>
            For unique challenges, Explore a diverse range of skills and
            expertise to meet your specific needs.
          </p>
        </div> -->
      </div>
    </div>
    <div class="page4">
      <div class="left">
        <h1>Seamless Tasks, Trusted Connections Your Safety, Our Priority!</h1>
      </div>
      <div class="right">
        <div class="box box1">
          <div class="boxin">
            <i class="ri-question-answer-line"></i>
            <h1>Messaging System</h1>
          </div>
          <p>
            Our built-in messaging system prioritizes your safety. Communicate
            with service providers within the platform without revealing
            personal contact information. Feel free to ask questions and discuss
            task details securely.
          </p>
        </div>
        <div class="box box2">
          <div class="boxin">
            <i class="ri-star-half-line"></i>
            <h1>Reviews and Ratings</h1>
          </div>
          <p>
            The power of trust lies in our community. Read reviews and ratings
            from other users to make informed decisions. Our review system
            ensures that only genuine experiences contribute to building a
            trustworthy community.
          </p>
        </div>
        <div class="box box3">
          <div class="boxin">
            <i class="ri-secure-payment-line"></i>
            <h1>Secure Payment</h1>
          </div>
          <p>
            Experience worry-free transactions. Our secure payment gateway
            ensures that your financial details are protected. Pay with
            confidence, knowing that every transaction is encrypted and
            monitored for your safety.
          </p>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="footerin">
        <!-- <div class="up">
          <div class="box box1">
            <h1>Discover</h1>
            <div class="boxin">
              <a href="" target="#">How it works</a>
              <a href="" target="#">Earn money</a>
              <a href="" target="#">Cost Guides</a>
              <a href="" target="#">Service Guides</a>
              <a href="" target="#">Comparison Guides</a>
              <a href="" target="#">New users FAQ</a>
            </div>
          </div>
          <div class="box box2">
            <h1>Company</h1>
            <div class="boxin">
              <a href="" target="#">About us</a>
              <a href="" target="#">Careers</a>
              <a href="" target="#">Media enquiries</a>
              <a href="" target="#">Community Guidelines</a>
              <a href="" target="#">Tasker Principles</a>
              <a href="" target="#">Terms and Conditions</a>
              <a href="" target="#">Contact us</a>
              <a href="" target="#">Privacy policy</a>
            </div>
          </div>
          <div class="box box3">
            <h1>Existing Members</h1>
            <div class="boxin">
              <a href="" target="#">Post a task</a>
              <a href="" target="#">Browse tasks</a>
              <a href="" target="#">Login</a>
              <a href="" target="#">Support center</a>
            </div>
          </div>
          <div class="box box4">
            <h1>Popular Categories</h1>
            <div class="boxin">
              <a href="" target="#">Electricians</a>
              <a href="" target="#">Plumber</a>
              <a href="" target="#">Mechanic</a>
              <a href="" target="#">Painter</a>
              <a href="" target="#">Gardner</a>
              <a href="" target="#">Cleaner</a>
              <a href="" target="#">Welder</a>
              <a href="" target="#">Others </a>
            </div>
          </div>
          <div class="box box5">
            <h1>Popular Location</h1>
            <div class="boxin">
              <a href="" target="#">Islamabad</a>
              <a href="" target="#">Karachi</a>
              <a href="" target="#">Lahore </a>
              <a href="" target="#">Peshawar</a>
              <a href="" target="#">Quetta</a>
              <a href="" target="#">Multan</a>
            </div>
          </div>
        </div> -->
        <div class="down">
          <div class="first">
            <div class="box box1">
              <a href="" target="#"><i class="ri-facebook-line"></i></a>
            </div>
            <div class="box box2">
              <a href="" target="#"><i class="ri-linkedin-line"></i></a>
            </div>
            <div class="box box3">
              <a href="" target="#"><i class="ri-twitter-x-line"></i></a>
            </div>
            <div class="box box4">
              <a href="" target="#"><i class="ri-youtube-line"></i></a>
            </div>
            <div class="box box5">
              <a href="" target="#"><i class="ri-instagram-line"></i></a>
            </div>
          </div>
          <div class="sec">
            <h4>All Right Reserved 2023</h4>
          </div>
        </div>
      </div>
    </div>

    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="Script.js"></script>
  </body>
</html>
