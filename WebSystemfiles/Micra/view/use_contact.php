<?php
    session_start();


    require '../controller/loginController.php';
    require '../resources/sendmessage.php';
    
    $send = new TextMessage();
    $controller = new LoginController();
    

    $error = '';
    

    
    if(isset($_POST['send'])){
        if($controller->checkContact($_POST['contact'])){
            $_SESSION['contact'] = $_POST['contact'];
            $_SESSION['otp'] = rand(1000,9999);
            $_SESSION['method'] = 'contact';
            
            $message = 'This is your OTP: '.$_SESSION['otp'];
            $number = $_POST['contact'];
        
            $send->sendSMS($number,$message);
            header('Location:../view/putOTP.php');
        }else{
            $error = 'Your phone number is not exist.';
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
                    <input type="text" class="form-control" name="contact" id="validContact" pattern="[0-9]+" placeholder="Insert your Registered Contact" required>
                    <label for="validEmail">Contact Number</label>
                </div>
                <button type="submit" class="btn form-control" name="send" value="send">Send OTP</button>
            </form>
        </div>
    </div>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>