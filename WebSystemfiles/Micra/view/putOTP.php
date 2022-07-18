<?php

    session_start();

    if(!isset($_SESSION['method'])){
        header('Location: login.php');
    }

    $error="";
    if(isset($_POST['submitOTP'])){
        if($_POST['yourOTP'] == $_SESSION['otp']){
            header('Location:changePass.php');
        }
        else{
            $error = 'Wrong OTP';
        }
    }


?>
<!----------- Header ----------->
<?php include '../resources/header/header.php'; ?>
<body class="loginBody">
    <div class="d-flex align-items-center vh-100">
        <div class="container p-5 border border-secondary rounded" id="forgotpass">
            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <span><h5 class="fs-6 fw-bold text-center text-danger"><?=$error?></h5></span>
                <div class="form-floating mb-4">
                    <input type="text" class="form-control" name="yourOTP" id="validOTP" placeholder="Insert your Registered Email" required>
                    <label for="validOTP">One-time PIN</label>
                </div>
                <button type="submit" class="btn form-control" name="submitOTP" value="send">Submit</button>
            </form>
        </div>
    </div>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>