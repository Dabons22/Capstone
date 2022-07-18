<?
include('config.php');
include('abtsite.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="../css/aj.css" rel="stylesheet">    
    <link href="../css/screen.css" rel="stylesheet">    
    <link href="../css/justified-nav.css" rel="stylesheet">
    <link href="../css/ajith.css" rel="stylesheet" type="text/css">
    <script src="../css/jquery-1.9.1.js"></script>
  <script src="../css/ajith.js"></script>
   
 
  </head>

 <!-- <body style="background-color:#5D4381; background-image:url(img/wal.jpg);">-->
  	 <body>
    <div class="container">
		<div class="col-md-3">
        </div>
        <div class="col-md-6">
        	<div class="panel panel-default">
              <div class="panel-body">
                <center>
                <h2> Admin <? echo $sitename; ?> </h2><br/></center>
                <form action="code/access.php" method="post" name="login">
                	<div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="name" name="userid" class="form-control" id="exampleInputEmail1" placeholder="Enter Username">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                      </div>
                      <center>
                      <button type="submit" class="btn btn-success">Login</button>
                	  </center>
                </form>
                <br>
              </div>
            </div>
        </div>
        <div class="col-md-3">
        </div>
        
    </div>
  </body>
</html>

