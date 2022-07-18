<?php
    
    require '../controller/announcementController.php';
    
    $controller = new AnnouncementController();
    
    $id = $_GET['id'];
    
    $controller->deleteAnnouncementById($id);
    echo 'Success';
    
    