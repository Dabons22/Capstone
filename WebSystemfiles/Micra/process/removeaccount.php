<?php

    require '../controller/userController.php';
    
    $controller = new UserController();
    
    $id = $_GET['id'];
    
    $controller->deleteAccount($id);
    
    echo 'success';