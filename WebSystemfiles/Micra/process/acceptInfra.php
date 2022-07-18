<?php 

    date_default_timezone_set('Asia/Taipei');

    require '../controller/tableController.php';
    require '../resources/sendmessage.php';

    $controller = new TableController();
    $send = new TextMessage();  
    
    
    $id = $_POST['accept'];
    $userID = $_POST['user'];
    $message = $_POST['message'];
    $responder = $_SESSION['fullname'];
    $respondDate = date('F d, Y');
    $respondTime = date('h:s:i a');
    
    $contact = $controller->getContact($userID);
    $email = $controller->getEmail($userID);
   
    $fromemail =  "itvengersdatabase.ver.2@gmail.com";
    $semi_rand = md5(uniqid(time()));
    $headers = "From: ".$fromemail;
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    $headers .= "\nMIME-Version: 1.0\n" ."Content-Type: multipart/mixed;\n" ." boundary=\"{$mime_boundary}\"";
    
    $subject = 'Report Status';
    $message = 'Your Report has been accepted. '.$message.'.';
    
    $send->sendSMS($contact,$message);
    mail($email, $subject, $message, $headers);
    
    
    $controller->updateInfraStatus('On-going',$id,$message,$responder,$respondDate,$respondTime);
    
    header('Location: ../view/pending_report.php');