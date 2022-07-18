<?php
    session_start();


    require '../controller/loginController.php';
    require '../resources/sendmessage.php';
    
    $send = new TextMessage();
    $controller = new LoginController();
    

    $error = '';
    

    
    if(isset($_POST['send'])){
        if($controller->checkEmail($_POST['email'])){
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['otp'] = rand(1000,9999);
            $_SESSION['method'] = 'email';
            
            $message = 'This is your OTP: '.$_SESSION['otp'];
            $subject = 'One-Time Pin';
            $email = $_POST['email'];

            $headers =  'MIME-Version: 1.0' . "\r\n"; 
            $headers .= 'From: Your name <itvengersdatabase.ver.2@gmail.com>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 


            if(mail($email,$subject,$message,$headers)){
                header('Location:../view/putOTP.php');
            }
        
            
        }else{
            $error = 'Your email is not exist.';
        }
    }

?>
<!----------- Header ----------->
<?php include '../resources/header/header.php'; ?>
<body class="loginBody">
    <div class="d-flex align-items-center vh-100">
        <div class="container p-5 border border-secondary rounded" id="forgotPass">
            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <span><h5 class="fs-6 fw-bold text-center text-danger"><?=$error?></h5></span>
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" name="email" id="validEmail" placeholder="Insert your Registered Email" required>
                    <label for="validEmail">Email</label>
                </div>
                <button type="submit" class="btn form-control" name="send" value="send">Send OTP</button>
            </form>
        </div>
    </div>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>