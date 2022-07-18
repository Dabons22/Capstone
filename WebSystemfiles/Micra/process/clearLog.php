<?php 

    require '../controller/loginController.php';
    
    $controller = new LoginController();
        
    $controller->clearLogs();
    
    echo 'Success';