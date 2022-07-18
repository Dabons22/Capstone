<?php 

    session_start();

    require '../controller/loginController.php';

    $controller = new LoginController();

    $failed="";
    
    if(isset($_SESSION['username']) && isset($_SESSION['id'])){
        header('Location: index.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['login'])){
            $username = $_POST['username'];
            $password= $_POST['password'];
            $controller->setData($username,$password);
            $session = $controller->setSession();

            if($session === true){
                $controller->loginTime($username);
                if($_SESSION['position'] != 'Main Administrator'){
                    header('Location: pending_report.php');
                }else{
                    header("Location: index.php");
                }
            }else{
                $failed = 'Incorrect Username or Password';
            }
        }
    }
?>
<!----------- Header ----------->
<?php include '../resources/header/header.php'; ?>


<!----------- Main Body ----------->
<body class="loginBody">
    <div class="vh-100">
        <div class="container p-5 border border-secondary" id="form-container">
            <div class="container text-center mb-5">
                <h2 class="display-2"><i class="bi bi-person-circle"></i></h2>
                <h5 class="fs-5 fw-bold">Micra Login</h5>
            </div>
            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <span>
                    <h5 class="fs-6 fw-bold text-danger text-center"><?= $failed; ?></h5>
                </span>
                <div class="col mb-3">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required autofocus>
                </div>
                
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required autocomplete>
                    <button class="btn" type="button" role="button" id="show"><i class="bi bi-eye"></i></button>
                </div>
                    <input type="hidden" value="hide" class="isHide">
                
                    <button type="submit" role="submit" class="form-control btn" name="login" value="sumbit">Login</button>
            </form>
            <hr class="mt-3">
            <div class="text-center">
                <a class="fs-6 text-decoration-none" id="forgot" href="choose_method.php">Forgot Password ?</a>
            </div>
        </div>
    </div>
    
<script>
    $(document).ready(function(){
        
        $('#show').click(function(){
            if($('.isHide').val() == 'hide'){
                $('.isHide').val('show')
                $('#show').html('<i class="bi bi-eye-slash"></i>')
                $('#password').attr('type','text')
            }else{
                $('.isHide').val('hide')
                $('#show').html('<i class="bi bi-eye"></i>')
                $('#password').attr('type','password')
            }
        })
        
    })
</script>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>
