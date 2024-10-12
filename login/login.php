<?php
session_start();
require('../connection.php');

if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['userType'];

    // Your existing login logic for normal users...
    if ($type == 'serviceProvider') {
        $sql = "SELECT * FROM `provider` WHERE `email` = '$email' AND `password` = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['UID'] = $row['pid'];
            $_SESSION['A_TYPE'] = 'Provider';
            header("location: ../Profile/profile.php");
        } else {
            echo "<script>alert('Invalid credentials!')</script>";
        }
    } else if ($type == 'serviceSeeker') {
        $sql = "SELECT * FROM `seeker` WHERE `email` = '$email' AND `password` = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['UID'] = $row['sid'];
            $_SESSION['A_TYPE'] = 'Seeker';
            header('Location: ../Client profile/cprofile.php');
        } else {
            echo "<script>alert('Invalid credentials!')</script>";
        }
    } else {
        echo ("<script>alert('Invalid user type')</script>");
        exit();
    }
}

// If you're going to process Google Sign-In
if (isset($_POST['id_token'])) {
    $id_token = $_POST['id_token'];

    // Use Google's API to verify the token
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
    $response = file_get_contents($url);
    $payload = json_decode($response, true);

    if (isset($payload['email'])) {
        $email = $payload['email'];

        // Check if the user exists in your database
        $sql = "SELECT * FROM `seeker` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0) {
            // User does not exist, send a message to the client to handle the redirect
            echo json_encode(['redirect' => '../sign up/Signup.php']);
            exit();
        } else {
            // User exists, log them in
            $row = mysqli_fetch_assoc($result);
            $_SESSION['UID'] = $row['sid'];
            $_SESSION['A_TYPE'] = 'Seeker';

            // You can also send a redirect for successful login if needed
            echo json_encode(['redirect' => '../Client profile/cprofile.php']);
            exit();
        }
    } else {
        echo json_encode(['error' => 'Invalid Google ID token']);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <link rel="stylesheet" href="login.css" />
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form id="loginForm" action="login.php" method="post">
        <div class="form-group">
            <label for="username">Email:</label>
            <input type="email" id="username" name="email" required />
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />
        </div>
        <div class="forgotpass"><a href="/login/forgot password/forgot_pass.html">Forgot Password</a></div>
        <div class="typee"><h4>Please enter your type</h4></div>
        <div class="radio-group">
            <label>
                <input type="radio" name="userType" value="serviceSeeker" required />
                Service Seeker
            </label>
            <label>
                <input type="radio" name="userType" value="serviceProvider" required />
                Service Provider
            </label>
        </div>
        <div class="form-group">
            <button type="submit" name="Login">Login</button>
        </div>
    </form>

    <div class="or-separator">
        <span>OR</span>
    </div>

    <div class="signup-section">
        <h3>Don't have an account? Sign up with</h3>
        <div class="social-login">
            <div id="g_id_onload"
                 data-client_id="398770279005-9sao8fm4gnujdkou2jksnbfq70fqstcg.apps.googleusercontent.com"
                 data-callback="handleCredentialResponse">
            </div>
            <div class="g_id_signin" data-type="standard"></div>
            <p>Or <a href="../sign up/signup.php">create an account</a> manually.</p>
        </div>
    </div>
</div>

<script>
    function handleCredentialResponse(response) {
        const id_token = response.credential;

        // Send the ID token to your server for verification
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'login.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Parse the JSON response
                const jsonResponse = JSON.parse(xhr.responseText);

                // Check if there is a redirect in the response
                if (jsonResponse.redirect) {
                    // Redirect the user to the provided URL
                    window.location.href = jsonResponse.redirect;
                } else if (jsonResponse.error) {
                    // Handle any errors (optional)
                    console.error('Error:', jsonResponse.error);
                    alert('Error: ' + jsonResponse.error);
                }
            } else {
                console.error('Error: ', xhr.responseText);
            }
        };
        xhr.send('id_token=' + id_token);
    }


    window.onload = function() {
        google.accounts.id.initialize({
            client_id: "398770279005-9sao8fm4gnujdkou2jksnbfq70fqstcg.apps.googleusercontent.com",
            callback: handleCredentialResponse
        });
        google.accounts.id.renderButton(
            document.getElementById("buttonDiv"),
            { theme: "outline", size: "large" } // customization
        );
        google.accounts.id.prompt(); // Display the One Tap prompt if possible
    };
</script>
</body>
</html>
