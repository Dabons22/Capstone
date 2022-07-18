<?php 
    
    date_default_timezone_set('Asia/Taipei');
    
    require '../controller/tableController.php';
    require '../resources/sendmessage.php';

    $controller = new TableController();
    $send =  new TextMessage();
    
    $userID = $_POST['user'];
    
    //User Contact Information
    
    $contact = $controller->getContact($userID);
    $email = $controller->getEmail($userID);
    
    //Message
    
    if(isset($_POST['message']) && !empty($_POST['message'])){
        $message = $_POST['message'];   
    }
    else{

        $message = 'Your Report has been Resolve. Thank you.';    

    }
    
    //Email Credentials
    
    $fromemail =  "itvengersdatabase.ver.2@gmail.com";
    $semi_rand = md5(uniqid(time()));
    $headers = "From: ".$fromemail;
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    $headers .= "\nMIME-Version: 1.0\n" ."Content-Type: multipart/mixed;\n" ." boundary=\"{$mime_boundary}\"";
    
    $subject = 'Report Status';
    
    
    $data = array(
        'id'=>$_POST['id'],
        'message'=>$message,
        'date'=>date('Y-m-d'),
        'time'=>date('h:i:s a')
    );    
    
    
    $send->sendSMS($contact,$message);
    mail($email, $subject, $message, $headers);
    
    $controller->updateFinishedIncident($data);

    header('Location: ../view/incident.php');
