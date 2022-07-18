<?php

    require '../controller/tableController.php';
    
    $controller = new TableController();
    
    $tablename = $_POST['table'];
    $search = $_POST['search'];
    
    $data = $controller->search($search,$tablename);
    
    echo $data;
    
    