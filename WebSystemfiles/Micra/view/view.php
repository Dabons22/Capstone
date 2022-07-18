<?
include('backend/config.php');
$link=$_GET['id'];
	$getnote = mysql_query("SELECT * FROM tbl_post WHERE link='$link'");
	$row= mysql_fetch_array($getnote);
	$head = $row['head'];
	$con = $row['con'];
	$pass = $row['password'];
	
?>
<!DOCTYPE html>
<html lang="en"><head>
  <!--/////////////(c)
                 Designed and developed by Ajith jojo (R)
                 ajithjojo07@gmail.com , +91 8129505560
                                    ///////////////-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
<META NAME="description" CONTENT="">
<META NAME="keywords" CONTENT="">
<META NAME="copyright" CONTENT="Copyright © 2014 . All Rights Reserved.">
<META NAME="author" CONTENT="Ajith jojo">
<META NAME="generator" CONTENT="www.">
<META NAME="revisit-after" CONTENT="1">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><? echo $head; ?></title>    
    <link href="css/aj.css" rel="stylesheet">    
    <link href="css/justified-nav.css" rel="stylesheet">
    <link href="css/ajith.css" rel="stylesheet" type="text/css">
    <script src="css/jquery-1.9.1.js"></script>
  <script src="css/ajith.js"></script>

  </head>

  	 <body>
    	<div class="container">
 			<div class="col-md-12">
            <img src="img/logo.png" style="margin-top:-10px; margin-bottom:10px;">
            <a href="index.php"> <button type="button" class="btn btn-danger btn-xs" style="float:right; margin-right:10px;"><span class="glyphicon glyphicon-file"></span> &nbsp; New Note</button></a> 
               <a href="savenotes.php"><button type="button" class="btn btn-primary btn-xs" style="float:right; margin-right:10px;"><span class="glyphicon glyphicon-book"></span> &nbsp; <? $cpost = mysql_query("SELECT * FROM tbl_post"); $cont = mysql_num_rows($cpost); echo $cont; ?> Notes saved</button></a> 
           
            </div>
            
            <div class="col-md-12">
                 
            	<div class="panel panel-default">
                  <div class="panel-heading"><span class="glyphicon glyphicon-file" ></span> &nbsp; <? echo $head; ?></div>
                  <div class="panel-body">
                  	<? if($pass==NULL) {				
                        echo $con; 
					}
					else
					{  ?>
                     <? 
				   		$newpa = $_POST['enterpass'];
						if($newpa==$pass)
						{
							echo $con;
						}
						else{
				   ?>
                   	<div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    	<center><h2>Please enter password</h2> </center>
                        <form action="" method="post">
                        <input type="password" name="enterpass" class="form-control" placeholder="Password">
                        
                        <center><button type="submit" class="btn btn-success " style=" margin-top:10px;"><span class="glyphicon glyphicon-lock" ></span> &nbsp; Enter </button> </center>
                        </form>
                    </div>
                    <div class="col-md-4">
                    </div>
                   
                   <? } } ?>
                  
                  </div>
                  
                </div>
                
            </div>
            <div class="col-md-12">
            	<center> &copy; 2014 mywordpad.com | Version 1.1 | <a href="http://ajithjojo.com" target="_blank"> App Developed by Ajith </a>   </center>
            </div>
 
 
		</div>
  </body>
  
<script src="tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: "textarea#elm1",
    theme: "modern",
    
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons | autosave ", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
</script>

   <script> $('.tp').tooltip();

  </script>

</html>

