<?php 

    require '../controller/tableController.php';

    session_start();
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }
    
    if($_SESSION['position'] !== 'Main Administrator'){
        header('Location: pending_report.php');
    }

    $controller = new TableController();
    $data = $controller->getFinished();

    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

?>
<!----------- Header ----------->
<?php include '../resources/header/header.php' ?>
<?php include '../resources/header/navigation.php' ?>

<!----------- Main Body ----------->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal1{
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content1 {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content1, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content1 {
    width: 100%;
  }
}


</style>


<body style="background-image: url('../resources/files/background.png'); background-repeat: none; background-attachment: fixed; background-size: cover;">
   <?php /* <div id="btnContainer">
  <button class="btn" onclick="listView()"><i class="fa fa-bars"></i> List</button> 
  <button class="btn active" onclick="gridView()"><i class="fa fa-th-large"></i> Grid</button>
</div> */?>


    <div class="container-fluid shadow mt-5 p-5"> <h1> REPORT LOGS</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
               
                <button class="nav-link active" id="incidentTab" data-bs-toggle="tab" data-bs-target="#incidentPanel" type="button" role="tab" aria-control="incidentPanel" aria-selected="true">Crime Reports</button>
                <button class="nav-link" id="infraTab" data-bs-toggle="tab" data-bs-target="#infraPanel" type="button" role="tab" aria-control="infraPanel" aria-selected="false">Infrastructure Reports</button>
                <button class="nav-link" id="wasteTab" data-bs-toggle="tab" data-bs-target="#wastePanel" type="button" role="tab" aria-control="wastePanel" aria-selected="false">Waste Reports</button>
            </div>
        </nav>
        
        <div class="tab-content" id="reportTabs">

            <!------------ CRIME Report ------------>
        
            <div class="tab-pane show active" id="incidentPanel" role="tabpanel" aria-labelledby="incidentTab">
                <span class="text-center"><h5 class="fs-5 fw-bolder mt-4"><?php if($data['incident']->num_rows == 0){echo 'No Finished Reports';} ?></h5></span>
                <div class="d-flex flex-wrap p-3">
                    <?php while($row = $data['incident']->fetch_assoc()){ ?>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <div class="card me-3 mb-5 border p-2" id="report">
                                <div class="text-center">
                                    <?php   $crimeImg = '../../IncidentReport/'.$row['reportimg']; 
                                            if(!file_exists($crimeImg) || empty($row['reportimg'])){ ?>
                                                <img src="../resources/files/background.png" alt="Report Image" class="card-img-top">
                                    <?php   }else{ ?>
                                                <img src="<?=$crimeImg?>" alt="Report Image" class="card-img-top">
                                    <?php   } ?>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><p class="card-title" name="reportID"><label class="fw-bold">Report ID :</label><?= ' '.$row['reportnumber']; ?></p></li>
                                        <li><p class="card-text"><label class="fw-bold">Category :</label><?= ' '.$row['reportcategory']; ?></p></li>
                                        
                                        <li><p class="card-text"><label class="fw-bold">Date of Crime:</label><?= ' '.$row['DateofIncident']?></p></li>
                                        
                                        <li><p class="card-text"><label class="fw-bold">Report Date:</label><?= ' '.$row['reportdate']?></p></li>
                                        
                                        <li><p class="card-text"><label class="fw-bold">Report Time:</label><?= ' '.$row['reporttime']?></p></li>
                                    
                                        <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['resolvestatus']?></p></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <button class="btn form-control" data-bs-toggle="modal" data-bs-target="<?='#additionalIncidentModal'.$row['reportnumber']; ?>">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="<?='additionalIncidentModal'.$row['reportnumber'] ?>" tabindex="-1" aria-labelledby="<?='additionalIncident'.$row['reportnumber']?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg model-dialog-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?='additionalIncident'.$row['reportnumber']?>">
                                            <i class="bi bi-exclamation-circle"></i> Additional Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div id="printCrime<?=$row['reportnumber']?>" class="modal-body">
                                        <table id='excelCrime<?=$row['reportnumber']?>'>
                                            
                                            <ul class="list-unstyled">
                                                
                                                <?php   $crimeImg = '../../IncidentReport/'.$row['reportimg']; 
                                                        if(!file_exists($crimeImg) || empty($row['reportimg'])){?>
                                                            <img src="<?=$root?>Micra/resources/files/background.png" alt="Proof" width="100%">
                                                <?php   }else{ ?>
                                                            <img id="myImg" src="<?=$root.''.$crimeImg?>" alt="Proof" width="100%">
                                                            <div id="myModal1" class="modal1">
  <span class="close">&times;</span>
  <img class="modal-content1" id="img01">
  <div id="caption"></div>
</div>
                                                <?php   } ?>
                                                
                                                <tr>
                                                    <td><p><label class="fw-bold">Reporter's Name: </label></td>
                                                    <td><?=' '.$row['reportername']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Location: </label></td>
                                                    <td><?= ' '.$row['reportlocation']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Category Description: </label></td>
                                                    <td><?= ' '.$row['categorydescription']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Report Description: </label></td>
                                                    <td><?= ' '.$row['reportdescription']; ?></p></td>
                                                </tr>
                                               
                                                <td><p><label class="fw-bold">Resolve Date: </label></td>
                                                    <td><?= ' '.$row['resolvedate']; ?></p></td>
                                                </tr>
                                                 <tr>
                                                    <td><p><label class="fw-bold">Resolve Time: </label></td>
                                                    <td><?= ' '.$row['resolvetime']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Feedback: </label></td>
                                                    <td><?= ' '.$row['resolvefeedback']; ?></p></td>
                                                </tr>
                                              
                                            </ul>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="mail.php" class="btn"><i class="bi bi-envelope"></i> E-mail</a>
                                     
                                      	<button type="button" name="btn-export" class="btn" value="Crime<?=$row['reportnumber']?>">
                                      	    <i class="bi bi-filetype-doc" onCLick="exportHTML();"></i> Export to Word
                                      	</button>
                                      	<button type="button" class="btn" name="printPDF" value="Crime<?=$row['reportnumber']?>"><i class="bi bi-printer"></i> Print</button>
                                      	
		                                <?php //<button type="button" id="export_button" class="btn">Export EXCEL</button> ?>
		                                <?php //<a><button type="button" id="btn-export" class="btn" onclick="exportHTML();">Export Word</button></a> ?>
		                                <?php //<button type="button" class="btn"id="pdf" onclick="printDiv('printMe')"><i class="bi bi-printer"></i> Print</button>    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            


            <!------------ Infrastructure Reports ------------>

            <div class="tab-pane" id="infraPanel" role="tabpanel" aria-labelledby="infraTab">
            <span class="text-center"><h5 class="fs-5 fw-bolder mt-4"><?php if($data['infrastructure']->num_rows == 0){echo 'No Finished Reports';} ?></h5></span>
                <div class="d-flex flex-wrap p-3">
                    <?php while($row = $data['infrastructure']->fetch_assoc()){ ?>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <div class="card me-3 mb-5 border p-2" id="report">
                                <div class="text-center">
                                    <?php   $infraImg = '../../Infrastracture/'.$row['reportimg']; 
                                            if(!file_exists($infraImg) || empty($row['reportimg'])){?>
                                                <img src="../resources/files/background.png" alt="Report Image" class="card-img-top">
                                    <?php   }else{ ?>
                                                <img src="<?=$infraImg?>" alt="Report Image" class="card-img-top">
                                    <?php   } ?>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><p class="card-title" name="reportID"><label class="fw-bold">Report ID :</label><?= ' '.$row['reportnumber']; ?></p></li>
                                        <li><p class="card-text"><label class="fw-bold">Category :</label><?= ' '.$row['reportcategory']; ?></p></li>
                                        
                                            <li><p class="card-text"><label class="fw-bold">Report Date:</label><?= ' '.$row['reportdate']?></p></li>
                                        
                                        <li><p class="card-text"><label class="fw-bold">Report Time:</label><?= ' '.$row['reporttime']?></p></li>
                                 
                                        <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['resolvestatus']?></p></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <button class="btn form-control" data-bs-toggle="modal" data-bs-target="<?='#additionalInfraModal'.$row['reportnumber']; ?>">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="<?='additionalInfraModal'.$row['reportnumber'] ?>" tabindex="-1" aria-labelledby="<?='additionalInfra'.$row['reportnumber']?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg model-dialog-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?='additionalInfra'.$row['reportnumber']?>">
                                            <i class="bi bi-exclamation-circle"></i> Additional Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div id="printInfra<?=$row['reportnumber']?>" class="modal-body">
                                         <table id='infraexcel'<?=$row['reportnumber']?>>
                                            <ul class="list-unstyled">
                                                <?php   $infraImg = '../../Infrastracture/'.$row['reportimg']; 
                                                        if(!file_exists($infraImg) || empty($row['reportimg'])){?>
                                                            <img src="<?=$root?>Micra/resources/files/background.png" alt="Proof" width="100%">
                                                <?php   }else{ ?>
                                                            <img src="<?=$root.''.$infraImg?>" alt="Proof" width="100%">
                                                <?php   } ?>
                                                <tr>
                                                    <td><p><label class="fw-bold">Reporter's Name: </label></td>
                                                    <td><?=' '.$row['reportername']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Location: </label></td>
                                                    <td><?= ' '.$row['reportlocation']; ?></p></td>
                                                </tr>
                                                 <tr>
                                                    <td><p><label class="fw-bold">Category Description: </label></td>
                                                    <td><?= ' '.$row['categorydescription']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Report Description: </label></td>
                                                    <td><?= ' '.$row['reportdescription']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Resolve Date: </label></td>
                                                    <td><?= ' '.$row['resolvedate']; ?></p></td>
                                                </tr>
                                                                                            <tr>
                                                    <td><p><label class="fw-bold">Resolve Time: </label></td>
                                                    <td><?= ' '.$row['resolvetime']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Feedback: </label></td>
                                                    <td><?= ' '.$row['resolvefeedback']; ?></p></td>
                                                </tr>
                                            </ul>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="mail.php"> <button type="button" class="btn"><i class="bi bi-envelope"></i> E-mail  </button> </a>
                                    
                                    	<button type="button" name="btn-export" class="btn" value="Infra<?=$row['reportnumber']?>" onCLick="exportHTML2()"><i class="bi bi-filetype-doc" ></i>Export Word</button>
		                                <button type="button" class="btn" name="printPDF" value="Infra<?=$row['reportnumber']?>"><i class="bi bi-printer"></i> Print</button>
		                                
		                                <?php //<button type="button" id="btn-export" class="btn" onclick="exportHTML2();">Export Word</button> ?>
                                        <?php //<button type="button" class="btn"id="pdf" onclick="printDiv('printMe2')"><i class="bi bi-printer"></i> Print</button> ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!------------ Waste Reports ------------>

            <div class="tab-pane" id="wastePanel" role="tabpanel" aria-labelledby="wasteTab">
            <span class="text-center"><h5 class="fs-5 fw-bolder mt-4"><?php if($data['waste']->num_rows == 0){echo 'No Finished Reports';} ?></h5></span>
                <div class="d-flex flex-wrap p-3">
                    <?php while($row = $data['waste']->fetch_assoc()){ ?>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <div class="card me-3 mb-5 border p-2" id="report">
                                <div class="text-center">
                                    <?php   $wasteImg = '../../Wastereport/'.$row['photo']; 
                                            if(!file_exists($wasteImg) || empty($row['photo'])){?>
                                                <img src="../resources/files/background.png" alt="Report Image" class="card-img-top">
                                    <?php   }else{ ?>
                                                <img src="<?=$wasteImg?>" alt="Report Image" class="card-img-top">
                                    <?php   } ?>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><p class="card-title" name="reportID"><label class="fw-bold">Report ID :</label><?= ' '.$row['reportnumber']; ?></p></li>
                                        <li><p class="card-text"><label class="fw-bold">Category :</label><?= ' '.$row['category']; ?></p></li>
                                        
                                       <li><p class="card-text"><label class="fw-bold">Report Date:</label><?= ' '.$row['dateReported']?></p></li>
                                        
                                        <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['status']; ?></p></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <button class="btn form-control" data-bs-toggle="modal" data-bs-target="<?='#additionalWasteModal'.$row['reportnumber']; ?>">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="<?='additionalWasteModal'.$row['reportnumber'] ?>" tabindex="-1" aria-labelledby="<?='additionalWaste'.$row['reportnumber']?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg model-dialog-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?='additionalWaste'.$row['reportnumber']?>">
                                            <i class="bi bi-exclamation-circle"></i> Additional Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div id="printWaste<?=$row['reportnumber']?>" class="modal-body">
                                         <table id='employee_data3'<?=$row['reportnumber']?>>
                                            <ul class="list-unstyled">
                                                <?php   $wasteImg = '../../Wastereport/'.$row['photo']; 
                                                        if(!file_exists($wasteImg) || empty($row['photo'])){?>
                                                            <img src="<?=$root?>Micra/resources/files/background.png" alt="Proof" width="100%">
                                                <?php   }else{ ?>
                                                            <img src="<?=$root.''.$wasteImg?>" alt="Proof" width="100%">
                                                <?php   } ?>
                                                <tr>
                                                    <td><p><label class="fw-bold">Reporter's Name: </label></td>
                                                    <td><?=' '.$row['firstname'].$row['lastname']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Location: </label></td>
                                                    <td><?= ' '.$row['location']; ?></p></td>
                                                </tr>
                                                 <tr>
                                                    <td><p><label class="fw-bold">Category Description: </label></td>
                                                    <td><?= ' '.$row['categoryDescription']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Report Description: </label></td>
                                                    <td><?= ' '.$row['Description']; ?></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p><label class="fw-bold">Feedback: </label></td>
                                                    <td><?= ' '.$row['feedback']; ?></p></td>
                                                </tr>
                                               
                                            </ul>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="mail.php"> <button type="button" class="btn"><i class="bi bi-envelope"></i></i> E-mail  </button> </a>
                                
		                  		        <button type="button" name="btn-export" class="btn" value="Waste<?=$row['reportnumber']?>" onCLick="exportHTML3()"><i class="bi bi-filetype-doc" ></i>Export Word</button>
		                  		        <button type="button" class="btn" name="printPDF" value="Waste<?=$row['reportnumber']?>"><i class="bi bi-printer"></i> Print</button>   
		                  		        
		                  		        <?php //<button type="button" id="btn-export" class="btn" onclick="exportHTML3();">Export Word</button> ?>
                                        <?php //<button type="button" class="btn"id="pdf" onclick="printDiv('printMe3')"><i class="bi bi-printer"></i> Print</button> ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
    	<!----------- WORD ----------->
    <?php /*<script>
        function exportHTML(){
           var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                "xmlns='http://www.w3.org/TR/REC-html40'>"+
                "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
          
           var sourceHTML = header+document.getElementById('excelCrime').innerHTML;
           
           var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
           var fileDownload = document.createElement("a");
           document.body.appendChild(fileDownload);
           fileDownload.href = source;
           fileDownload.download = 'Report.doc';
           fileDownload.click();
           document.body.removeChild(fileDownload);
        }
    </script>
    	<script>
        function exportHTML2(){
           var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                "xmlns='http://www.w3.org/TR/REC-html40'>"+
                "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
          
           var sourceHTML = header+document.getElementById('infraexcel').innerHTML;
           
           var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
           var fileDownload = document.createElement("a");
           document.body.appendChild(fileDownload);
           fileDownload.href = source;
           fileDownload.download = 'Report.doc';
           fileDownload.click();
           document.body.removeChild(fileDownload);
        }
    </script>
        </script>
    	<script>
        function exportHTML3(){
           var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                "xmlns='http://www.w3.org/TR/REC-html40'>"+
                "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
          
           var sourceHTML = header+document.getElementById('employee_data3').innerHTML;
           
           var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
           var fileDownload = document.createElement("a");
           document.body.appendChild(fileDownload);
           fileDownload.href = source;
           fileDownload.download = 'Report.doc';
           fileDownload.click();
           document.body.removeChild(fileDownload);
        }
    </script>
   */ ?>
<?php 
    /*<script>
        function exportHTML(){
           var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
                "xmlns:w='urn:schemas-microsoft-com:office:word' "+
                "xmlns='http://www.w3.org/TR/REC-html40'>"+
                "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
          
           var sourceHTML = header+document.getElementById('printMe').innerHTML;
           
           var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
           var fileDownload = document.createElement("a");
           document.body.appendChild(fileDownload);
           fileDownload.href = source;
           fileDownload.download = 'Report.doc';
           fileDownload.click();
           document.body.removeChild(fileDownload);
        }
    </script>*/
?>

<!----------- Sample Print PDF ----------->
<script>
    $(document).ready(function(){
        //Export to Word
        $('button[name="btn-export"]').on('click',function(){
            var getId = $(this).val()
            var exportId = 'print'+ getId
            
            var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "
            header += "xmlns:w='urn:schemas-microsoft-com:office:word' "
            header += "xmlns='http://www.w3.org/TR/REC-html40'>"
            header += "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body><p> <center><em>Republika ng Pilipinas</em></center></p> <br> <p><center><strong>BARANGAY MASAMBONG</strong></center></p><p><center>TANGGAPAN NG PUNONG BARANGAY</center></p><br> <p><center><em>Ika-1 Distrito, Lungsod Quezon</em></center></p> <br> "
        
            var sourceHTML = header + $('#'+exportId).html()
            
            var source = 'data:application/vnd.ms-word;charset=UTF-8,'+ encodeURIComponent(sourceHTML);
            
            var fileDownload = document.createElement('a');
            $('body').append(fileDownload)
            fileDownload.href = source
            fileDownload.download = getId+'.doc'
            fileDownload.click()
            $('body').remove(fileDownload)
        })
        
        
        
        //Print Report PDF
        $('button[name="printPDF"]').on('click',function(){
            var getId = $(this).val()
            var printId = 'print' + getId
            var t = "<p> <center><em>Republika ng Pilipinas</em></center></p> <p><center><strong>BARANGAY MASAMBONG</strong></center></p><p><center>TANGGAPAN NG PURONG BARANGAY</center></p> <p><center><em>Ika-1 Distrito, Lungsod Quezon</em></center></p> <p></p>"
            var b = "<p>BARANGAY MASAMBONG OFFICIAL</p>"
             var a = "<p>Generated by: Jasmine B. Motin - The Barangay Secretary</p>"
            
            var printContent =t + $('#'+printId).html()+b+a
            $('body').html(printContent)
            window.print()
            location.reload()
        })
        
        //Export to Excel
        $('button[name="excelButton"]').click(function(){
            var getId = $(this).val()
            var table = 'excel' + getId
            
            var file = XLSX.utils.table_to_book(table,{sheet: 'sheet1'})
            
            
            XLSX.write(file,{bookType: 'xlsx',bookSST: true,type: 'base64' })
            XLSX.writeFile(file,getId+'.xlsx')
            const excelButton = document.getElementById('excelButton');

        })
    })
</script>

<script>
    function html_table_to_excel(type){
        var data = document.getElementById('employee_data');
        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
        XLSX.writeFile(file, 'file.' + type);
    }

    const export_button = document.getElementById('export_button');

    export_button.addEventListener('click', () =>  {
        html_table_to_excel('xlsx');
    });
    
</script>

<script>
// Get the elements with class="column"
var elements = document.getElementsByClassName("tab-pane");

// Declare a loop variable
var i;

// List View
function listView() {
  for (i = 0; i < elements.length; i++) {
    elements[i].style.width = "50%";
  }
}

// Grid View
function gridView() {
  for (i = 0; i < elements.length; i++) {
    elements[i].style.width = "100%";
  }
}

/* Optional: Add active class to the current button (highlight it) */
var container = document.getElementById("btnContainer");
var btns = container.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>

<?php /*
    <script>
    function exportHTML2(){
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
      
       var sourceHTML = header+document.getElementById('printMe2').innerHTML;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'Report.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
    }
</script>

<script>
    function exportHTML3(){
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
      
       var sourceHTML = header+document.getElementById('printMe3').innerHTML;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'Report.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
    }
</script>
<!----------- Print PDF ----------->
<script>
	function printDiv(divName){
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;

	}
</script>
*/?>

<!----------- Export to Excel ----------->

<script>
    function  html_table_to_excel(type){
        var data = document.getElementById('employee_data3');
        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
        
        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
        XLSX.writeFile(file, 'file.' + type);
    }

    const export_button3 = document.getElementById('export_button3');

    export_button3.addEventListener('click', () =>  {
        html_table_to_excel('xlsx');
    });

</script>

<script>
// Get the modal
var modal = document.getElementById("myModal1");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>

<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>