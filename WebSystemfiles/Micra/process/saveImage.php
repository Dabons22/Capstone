<?php
    session_start();

    require '../controller/profileController.php';
    
    
    $controller = new ProfileController();
    
    if(isset($_POST['image'])){
        $id = $_SESSION['id'];
        $username = $_SESSION['username'];
        $image = $_POST['image'];
        
        $image_array_1 = explode(';',$image);
        $image_array_2 = explode(',',$image_array_1[1]);
        
        $image = base64_decode($image_array_2[1]);
        $filename = $username.'_'.time().'.png';
        $directory = '../resources/files/user/'.$filename;
        
        file_put_contents($directory,$image);
        $controller->changeProfile($id,$filename);
        
        echo $directory;
    }
    

    