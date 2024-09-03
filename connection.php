<?php 


    $host = "localhost";
    $user = "root"; 
    $password = ""; // We will configure it during deployment phase. For testing it will remain empty
    $dbname = "taskker_db"; 


    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

?>