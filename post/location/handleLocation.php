<?php 

    session_start();

    if(isset($_POST['ADD_LOCATION'])){    
    
        $city = $_POST['myCountry'];
        
        $_SESSION['T_CITY'] = $city;

        header("Location: ../description/description.html");
    }
?>