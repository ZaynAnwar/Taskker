<?php 

    session_start();

    if(isset($_POST['ADD_BUDGET'])){
        $budget = $_POST['budget'];

        $_SESSION['T_BUDGET'] = $budget;

        header('location: ../handlePost.php');


    }

?>