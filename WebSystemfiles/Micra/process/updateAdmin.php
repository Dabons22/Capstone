<?php 

    require '../controller/adminController.php';
    
    $controller = new AdminController();
    
    $id= $_POST['id'];
    $position = $_POST['position'];
    
    $controller->changeAccount($id,$position);
    
    echo 'Account Update Successfully';