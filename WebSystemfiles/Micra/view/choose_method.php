<?php
    session_start();
?>
<!----------- Header ----------->
<?php include '../resources/header/header.php'; ?>
<body class="loginBody">
    <div class="d-flex align-items-center vh-100">
        <div class="container p-5 border border-secondary rounded" id="forgotPass">
            <a class="btn form-control mb-4" href="use_email.php">Via Email</a>
            <a class="btn form-control" href="use_contact.php">Via Phone Number</a>
        </div>
    </div>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>