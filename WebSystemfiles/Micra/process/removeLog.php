<?php

    require '../controller/loginController.php';
    
    $controller = new LoginController();
    
    $id = $_GET['id'];
    
    $controller->removeOneLog($id);
    
    echo 'success';