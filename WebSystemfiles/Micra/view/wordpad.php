
<!----------- Header ----------->
<?php include '../resources/header/header.php' ?>
<?php include '../resources/header/navigation.php' ?>
<html>
<head>
     <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
  <title> Full Details Report</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="img/favicon.ico">

    <title>Report</title>    
    <link href="css/aj.css" rel="stylesheet">    
    <link href="css/justified-nav.css" rel="stylesheet">
    <link href="css/ajith.css" rel="stylesheet" type="text/css">
    <script src="css/jquery-1.9.1.js"></script>
  <script src="css/ajith.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js">
        </script>
         <STYLE TYPE="text/css">
        .button {
    
  background-color: red; 
  border: none;
   border-radius: 4px;
  color: white;
  padding: 8px 26px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  font:Lucida;
 
  
  
}
</style>
        </head>
        <body>
            
     <div class="col-md-12">
 
           
            </div>
            <div class="col-md-12">
            	<div class="panel panel-default" id="<?='additionalIncident'.$row['reportnumber']?>">
                  <div class="panel-heading"><span class="glyphicon glyphicon-file" ></span> &nbsp; WRITE A REPORT</div>
                  <div class="panel-body" >
                       <form  method="post" name="blog">
                          
                                
                             	<textarea class="form-control" id="word"  rows="12"   > </textarea>
                             	
                                <button onclick="exportHTML2();" id="btn" class="btn btn-success flot_rightex" style=" float:right; margin-top:10px;"><span class="glyphicon glyphicon-save" ></span> &nbsp; Save  </button> 
                                

                                <div class="col-xs-4" style="margin-top:6px; ">
                                  <a href="finish_report.php" id="infraPanel"> <button type="button" class="button button2"><i class="fas fa-arrow-alt-circle-left"></i> BACK  </button> </a>
                             
                             </form>  
                  </div>
                </div>
                  
            </div>
        
 

		</div>
	</body>
<script src="tinymce/tinymce.min.js"></script>
	<script>
tinymce.init({
    selector: "textarea#word",
    theme: "modern",
    
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons fullscreen | autosave ", 
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

<!-- save doc -->
<script>
    function exportHTML2(){
        
         var x = tinymce.get("word").getContent();
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head> <body> <br>";
       var footer = "<br></body></html>";
       var sourceHTML = header+x+footer;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'document.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
    }
</script>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>
	</html>
	