<?php
session_start();

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Exchange the authorization code for an access token
    // Here you would typically use cURL or another method to make a request to Google's token endpoint

    // Example: Use a library to handle the token exchange (or do it manually)
    $clientId = 'YOUR_CLIENT_ID';
    $clientSecret = 'YOUR_CLIENT_SECRET';
    $redirectUri = 'http://localhost/Taskker/login/callback.php';

    $url = 'https://oauth2.googleapis.com/token';

    $data = array(
        'code' => $code,
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'redirect_uri' => $redirectUri,
        'grant_type' => 'authorization_code'
    );

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        // Handle error
        die('Error fetching token');
    }

    $response = json_decode($result, true);
    $accessToken = $response['access_token'];

    // Use the access token to get user info
    // Save user info in session or database
    $_SESSION['access_token'] = $accessToken;
    // Redirect to a protected page or dashboard
    header('Location: ../Profile/profile.php');
    exit();
} else {
    // Handle error or invalid request
    die('Authorization code not received');
}
?>
