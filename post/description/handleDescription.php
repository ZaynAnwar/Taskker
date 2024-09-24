<?php 

    session_start();

    if(isset($_POST['ADD_DESCRIPTION'])){
        $description = $_POST['description'];

        $_SESSION['T_DESCRIPTION'] = $description;
        header('location: ../budget/budget.html');
    }

?>