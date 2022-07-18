<?php
    
    require '../controller/userController.php';
    require '../resources/sendmessage.php';
    
    $controller = new UserController();
    /** $sendmessage = new TextMessage();
    
    $id = $_POST['accept'];
    $phone = $_POST['number'];
    $message = 'Your Account has been Verified';
    
    $controller->isVerified($id);
    $sendmessage->sendSMS($phone,$message);
    **/
    
    $send = new TextMessage();  
    
    $id = $_POST['accept'];
    $message = 'Your account has been Verified';
    $phone = $_POST['number'];
    

    $controller->isVerified($id);
    $wholeMessage = $message;
    
    $send->sendSMS($phone,$wholeMessage); 
    
    
    $statusMsg='';
    $email = $_POST['email'];
    $message = 'Your Account has been Verified';
    $fromemail =  "itvengersdatabase.ver.2@gmail.com";
    $email_message = 
        'BARANGAY MASAMBONG
        Name : '.$email.'
        Message from Masambong :'.$message. '.';
    
    $semi_rand = md5(uniqid(time()));
    $headers = "From: ".$fromemail;
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 
    $headers .= "\nMIME-Version: 1.0\n" ."Content-Type: multipart/mixed;\n" ." boundary=\"{$mime_boundary}\"";
    
    
 /**
if($_FILES["file"]["name"]!= ""){  
	$strFilesName = $_FILES["file"]["name"];  
	$strContent = chunk_split(base64_encode(file_get_contents($_FILES["file"]["tmp_name"])));  
	
	
    $email_message .= "This is a multi-part message in MIME format.\n\n" .
    "--{$mime_boundary}\n" .
    "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" .
    $email_message .= "\n\n";
 
 
    $email_message .= "--{$mime_boundary}\n" .
    "Content-Type: application/octet-stream;\n" .
    " name=\"{$strFilesName}\"\n" .
    //"Content-Disposition: attachment;\n" .
    //" filename=\"{$fileatt_name}\"\n" .
    "Content-Transfer-Encoding: base64\n\n" .
    $strContent  .= "\n\n" .
    "--{$mime_boundary}--\n";
}
**/

    $toemail=$email;	
    if(mail($toemail, $message, $email_message, $headers)){
       $statusMsg= "Email sent!!";
    }else{
       $statusMsg= "Not sent";
    }

  
    header('Location: ../view/user_registration.php');
    ?>