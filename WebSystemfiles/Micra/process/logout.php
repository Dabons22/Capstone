<?php
    session_start();
    require '../controller/loginController.php';

    $controller = new LoginController();
    
    $username = $_SESSION['username'];
    $login = $_SESSION['logintime'];
    $date = $_SESSION['logindate'];
    
    $controller->logoutTime($username,$date,$login);


    $_SESSION = array();
    session_destroy();

    header('Location:../view/login.php');