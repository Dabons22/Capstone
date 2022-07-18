<?php
    session_start();
    
    require '../controller/loginController.php';
    
    $controller = new LoginController();
    
    if(!isset($_SESSION['method'])){
        header('Location: ../view/login.php');
    }
 

    $error="";
    if(isset($_POST['submit'])){
          if($_POST['confirmpass'] != $_POST['newpass']){
            $error = 'Your New Password and Confrim Password is not the Same';
        }else{
            if($_SESSION['method'] == 'email'){
                $controller->usingEmail($_POST['confirmpass'],$_SESSION['email']);
                session_destroy();
                header('Location: ../view/login.php');
            }
            
            if($_SESSION['method'] == 'contact'){
                $controller->usingContact($_POST['confirmpass'],$_SESSION['contact']);
                session_destroy();
                header('Location: ../view/login.php');
                
            }
        }  
    }

?>
<!----------- Header ----------->
<?php include '../resources/header/header.php'; ?>
<body class="loginBody">
    <div class="d-flex align-items-center vh-100">
        <div class="container p-5 border border-secondary rounded" id="form-container">
            <form class="pt-5" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <span><h5 class="fs-6 fw-bold text-center text-danger"><?=$error?></h5></span>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" name="newpass" id="newPassword" placeholder="Your New Password" required>
                    <label for="newPassword">New Password</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" name="confirmpass" id="confirmPassword" placeholder="Confirm Password" required>
                    <label for="newPassword">Confirm Password</label>
                </div>
                <button type="submit" class="btn form-control" name="submit" value="submit">Submit</button>
            </form>
        </div>
    </div>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>