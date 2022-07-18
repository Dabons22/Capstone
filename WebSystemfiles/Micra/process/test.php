<?php 
    require '../controller/announcementController.php';

    $file = $_FILES['image']['name'];
    $target = '../resources/files/announcement/'.$file;
    
    if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
        echo 'Success';
    }else{
        echo 'Failed';
    }