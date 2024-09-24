<?php 

    session_start();


    if(isset($_POST['ADD_POST'])){
        $title  = $_POST['title'];
        $onDate = $_POST['date'] ? $_POST['date'] : ''; 
        $beforeDate = $_POST['date2'] ? $_POST['date2'] : '';


        $_SESSION['T_TITLE'] = $title;
        $_SESSION['T_ONDATE'] = $onDate;
        $_SESSION['T_BEFOREDATE'] = $beforeDate;

        header('location: ../location/location.html');


    } else {
        echo "ERROR: Form is not responding";
    }




?>