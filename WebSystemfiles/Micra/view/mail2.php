<?php 

    require '../controller/tableController.php';

    session_start();
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }



?>
<!----------- Header ----------->
<?php include '../resources/header/header.php' ?>
<?php include '../resources/header/navigation.php' ?>

<?php
$statusMsg='';
if(isset($_FILES["file"]["name"])){
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
   $statusMsg= "Email send successfully with attachment";
}else{
   $statusMsg= "Not sent";
}
}
   ?>


<!DOCTYPE html>
<html>
    <head><title>SEND EMAIL </title>
     <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <style>
        /* Style inputs with type="text", select elements and textareas */
input[type=text], select, textarea {
  width: 70%; /* Full width */
  padding: 9px; /* Some padding */ 
  border: 1px solid #ccc; /* Gray border */
  border-radius: 10px; /* Rounded borders */
  box-sizing: border-box; /* Make sure that padding and width stays in place */
  margin-top: 6px; /* Add a top margin */
  margin-bottom: 16px; /* Bottom margin */
  resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
  font: helvetica;
}
input[type=textname] {
  width: 70%; /* Full width */
  padding: 9px; /* Some padding */ 
  border: 1px solid #ccc; /* Gray border */
  border-radius: 10px; /* Rounded borders */
  box-sizing: border-box; /* Make sure that padding and width stays in place */
  margin-top: 6px; /* Add a top margin */
  margin-bottom: 16px; /* Bottom margin */
    margin-left: 100px;
  resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
  font: helvetica;
}
input[type=texttt] {
  width: 70%; /* Full width */
  padding: 9px; /* Some padding */ 
  border: 1px solid #ccc; /* Gray border */
  border-radius: 10px; /* Rounded borders */
  box-sizing: border-box; /* Make sure that padding and width stays in place */
  margin-top: 6px; /* Add a top margin */
  margin-bottom: 16px; /* Bottom margin */
    margin-left: 100px;
  resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
  font: helvetica;
}
textarea[name=message]{
      width: 70%; /* Full width */
  padding: 9px; /* Some padding */ 
  border: 1px solid #ccc; /* Gray border */
  border-radius: 10px; /* Rounded borders */
  box-sizing: border-box; /* Make sure that padding and width stays in place */
  margin-top: 6px; /* Add a top margin */
  margin-bottom: 16px; /* Bottom margin */
  margin-left: 100px;
  resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
  font: helvetica;
}
.placeholder{
    font: helvetica;
}
/* Style the submit button with a specific background color etc */
input[type=submit] {
  background-color:  #e60026;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=file] {

  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font color: black;
}
div[name=succ]{
    padding: 12px 30px;
    width:53%;
	margin-left: 100px;
    margin-right: 400px;
    
}
form{
    font-family: helvetica;
    font-weight: bold;
    margin-left: 100px;
    margin-right: 400px;
  }


/* Add a background color and some padding around the form */

.button {
  background-color: #e60026; /* Green */
  border: none;
   border-radius: 4px;
  color: white;
  padding: 8px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  font:helvetica;
}
.button1 {
  background-color: #e60026;
  font:helvetica;
  color: white;
    border: 2px solid  #e60026;
}
.button1:hover {
  font:helvetica;
  background-color: white;
  color: black;
}
 .button2 {
    font:helvetica;
  background-color:  #e60026;
  color: white;
  border: 2px solid  #e60026;
   border-radius: 4px;
}
h1{

    margin-left: 100px;
    margin-right: 400px;
  }
  
 p{
	background:#90EE90;
	border:1px solid #90EE90;
	color:#ffffff;
	width:30%;
	margin-left: 100px;
    margin-right: 400px;
     font-size: 20px;
     border-radius: 10px;
     padding: 12px 20px;
}

    </style>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    </head>
    <body style="background-image: url('../resources/files/background.png'); background-repeat: none; background-position: fixed; background-position: left;">
        

  <?php /* if(!empty($statusMsg)){ ?>
    <div name="succ" class="alert alert-success"  padding=" 12px 20px"><?php echo $statusMsg; ?></div>
<?php } */?>
<!-- Display contact form -->
<h1>SEND EMAIL</h1>
<form  enctype="multipart/form-data" id="send">
    <div class="form-group">
    <label for="firstname" class="form-label">Enter Name </label>
        <input type="textname" id="name" name="name" class="form-control" placeholder="Enter Name"  required=""> 
    </div>
    <div class="form-group">
    <label for="email" class="form-label">Email Address &nbsp</label>
  <input type="texttt" name="email" id="email" class="form-control" list="mail" placeholder="Email address" required>
 <datalist id="mail">
  <option value="dilgofficial@gmail.com">
  <option value="brgymasambong@gmail.com">
  <option value="qcmail.@gmail.com">
  <option value="emergencytruck@gmail.com">
  <option value="truckservicers@gmail.com">
  <option value="callserv@gmail.com">
 
    </div>
    <div class="form-group">
    <label for="sub">Subject  &nbsp &nbsp &nbsp &nbsp &nbsp</label>
  <select id="subb" name="subject" required>
    <option value="Crime">Crime</option>
    <option value="Infrastracture">Infrastracture</option>
    <option value="Waste">Waste</option>
  </select>
    </div>
    <div class="form-group">
    <label for="firstname" class="form-label">Message</label>
        <textarea name="message" id="message" class="form-control" placeholder="Message" required></textarea>
    </div>
    <div class="form-group">
        <input type="file" name="file" id="file" class="form-control" required>
    </div><br><ln></ln>
    <div class="submit">
        <a href="index.php"> <button type="button" class="button button2"><i class="fas fa-arrow-alt-circle-left"></i> BACK  </button> </a>
       <button type="submit" name="submit" class="button button2"value="SEND EMAIL"><i class="fa fa-paper-plane fw-fa"></i> SEND EMAIL  </button>
        
    </div>
   

                 
</form> 


                        </div>
                    </div>
                </div>

                
</body>
<script>
    
    $(document).ready(function(){
        $('#send').submit(function(event){
            event.preventDefault();
            var formData = new FormData(this)
              $.ajax({
                    url: '../process/emailsend.php',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(data){
                     
                        console.log(data)
                        var message = data
                        swal({
                            title: message,
                            icon: 'success',
                            button: 'Okay'
                        })
                    }
              })
        })
    })
    
</script>

 <!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>
</html>