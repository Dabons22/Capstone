<?php

    require '../controller/adminController.php';
    
    $controller = new AdminController();
    
    $id = $_POST['id'];
    
    $controller->removeAccount($id);
    echo ' Remove Successfully';