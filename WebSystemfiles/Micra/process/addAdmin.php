<?php 

    require '../controller/adminController.php';

    $adminController = new AdminController();
    $fullname = $_POST['firstname'].' '.$_POST['lastname'];
    $data = array(
        'username'=> $_POST['username'],
        'password'=> $_POST['password'],
        'fullname'=> $fullname,
        'position'=> $_POST['position'],
        'contact'=> $_POST['contact'],
        'email'=> $_POST['email']
    );

    if(!$adminController->isExist($data['username']) && !$adminController->isExistEmail($data['email']) && !$adminController->isExistContact($data['contact'])){
      $adminController->addAccount($data);
        echo json_encode($data);
    }elseif($adminController->isExist($data['username'])){
        echo 'username';
    }elseif($adminController->isExistEmail($data['email'])){
        echo 'email';
    }elseif($adminController->isExistContact($data['contact'])){
        echo 'contact';
    }