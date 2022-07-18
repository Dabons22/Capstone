<?php
$statusMsg='';
if(isset($_FILES["file"]['name'])){
   $email = $_POST['email'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
$fromemail =  "itvengersdatabase.ver.2@gmail.com";
$subject=$subject;
$email_message = '<h2>CASE REPORT UPDATE</h2>
                    <p><b>Name:</b> '.$name.'</p>
                    <p><b>Email:</b> '.$email.'</p>
                    <p><b>Subject:</b> '.$subject.'</p>
                    <p><b>Message:</b><br/>'.$message.'</p>';
$email_message.="Thank You!";
$semi_rand = md5(uniqid(time()));
$headers = "From: ".$fromemail;
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 
    $headers .= "\nMIME-Version: 1.0\n" .
    "Content-Type: multipart/mixed;\n" .
    " boundary=\"{$mime_boundary}\"";
 
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
$toemail=$email;	
 
if(mail($toemail, $subject, $email_message, $headers)){
   $statusMsg= "Email sent successfully!!";
}else{
   $statusMsg= "Not sent";
}
}
   echo $statusMsg ;
   ?>