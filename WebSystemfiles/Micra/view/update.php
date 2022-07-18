<?php
    require '../controller/loginController.php';
    session_start();
?>

<html>
    <body>
        <form method="POST">
            <input type="text" name="usern" value="<?php echo $_SESSION['username']; ?>">
            <input type="submit" value="Update" name="sub">
        </form>
    </body>
</html>


<?php
    $servername = "localhost";
    $username = "id18437919_micradb";
    $password = "Micradbthesis2@";
    $dbname = "id18437919_micra";
    

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    
    if(isset($_POST['sub']))
    {
        $sql = "UPDATE tbluseraccounts SET USERNAME ='" . $_POST['usern'] . "' WHERE ID = '" . $_SESSION['id'] . "'";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
            
        }
    }
    
    
?>