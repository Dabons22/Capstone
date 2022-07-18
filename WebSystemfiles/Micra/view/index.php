<?php 
    require '../controller/chartController.php';
    require_once 'connection.php';
    
    session_start();

    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }
    
    if($_SESSION['position'] != 'Main Administrator' and $_SESSION['position'] != 'Barangay Chairman'){
        header('Location: pending_report.php');
    }

    
    $controller = new ChartController();
    $registered = $controller->totalRegistred();
    $totalOngoing = $controller->totalOngoing();
    $totalFinished = $controller->totalFinished();
    $narrative = $controller->showNarrative();
    $narrative2 = $controller->showNarrative2();
    $narrative3 = $controller->showNarrative3();
    
    $data = $controller->getFinished();
    
    if(isset($_POST['submit'])){
    	$textareaValue = trim($_POST['content']);
        $category =  trim($_POST['drone']);
        
        $filecontent = $textareaValue;
        $filename = $_POST['filename'].'.doc';
        $date = date('F d, Y');
        $file = fopen('../resources/files/narrative/'.$filename,'w');
        fwrite($file,$filecontent);
        fclose($file);
    	
    	$sql = "insert into saved_notes(textarea_content,category,date) values ('$filename','$category','$date')";
    	$rs = mysqli_query($conn, $sql);
    	$affectedRows = mysqli_affected_rows($conn);
	
    	if($affectedRows == 1){
    		$successMsg = "Record has been saved successfully";
    	}
    }
    
      
?>
<!----------- Header ----------->
<?php 
    include '../resources/header/header.php';
    
    if($_SESSION['position'] == 'Main Administrator'){
        include '../resources/header/navigation.php'; 
    }else{
        include '../resources/header/head_navigation.php'; 
    }
?>
<!----------- Main Body ----------->

<body>
    <div class="container-fluid mb-5">
        <div class="container shadow mb-3 text-center">
            <diiv class="row gx-3">
                <div class="col p-3">
                    <a class="text-dark text-decoration-none" href="../view/finish_report.php"><h4 class="fs-2"><i class="bi bi-clipboard-check"></i></h4></a>
                    <label class="fs-6 fw-bold">Finished Report</label>
                    <h3 class="fs-1 fw-bold mt-2"><?= $totalFinished['Incident'] + $totalFinished['Infrastructure'] + $totalFinished['Waste'] ?></h3>
                </div>
                <div class="col p-3">
                    <h4 class="fs-2"><i class="bi bi-clipboard"></i></h4>
                    <label class="fs-6 fw-bold">Ongoing Report</label>
                    <h3 class="fs-1 fw-bold mt-2"><?= $totalOngoing['Incident'] + $totalOngoing['Infrastructure'] + $totalOngoing['Waste']  ?></h3>
                </div>
                <div class="col p-3">
                    <a class="text-dark text-decoration-none" href="../view/incident.php"><h4 class="fs-2"><i class="bi bi-cone-striped"></i></h4></a>
                    <label class="fs-6 fw-bold">Crime Report</label>
                    <h3 class="fs-1 fw-bold mt-2"><?= $totalOngoing['Incident'] ?></h3>
                </div>
                <div class="col p-3">
                    <a class="text-dark text-decoration-none" href="../view/infrastructure.php"><h4 class="fs-2"><i class="bi bi-building"></i> </h4></a>
                    <label class="fs-6 fw-bold">Infrastructure</label>
                    <h3 class="fs-1 fw-bold mt-2"><?= $totalOngoing['Infrastructure']; ?></h3>
                </div>
                <div class="col p-3">
                    <a class="text-dark text-decoration-none" href="../view/waste.php"><h4 class="fs-2"><i class="bi bi-trash"></i></h4></a>
                    <label class="fs-6 fw-bold">Waste Reports</label>
                    <h3 class="fs-1 fw-bold mt-2"><?= $totalOngoing['Waste']; ?></h3>
                </div>
                <div class="col p-3">
                    <h4 class="fs-2"><i class="bi bi-person-check"></i></h4>
                    <label class="fs-6 fw-bold">Registered User</label>
                    <h3 class="fs-1 fw-bold mt-2"><?= $registered['verified']; ?></h3>
                </div>
            </diiv>
        </div>
        <div class="container border mb-4 p-5 shadow" id="totalReportChart">
            <h5 class="fs-4 fw-bold text-center">Total Reports</h5>
            <canvas id="totalReport"></canvas>
        </div>
        
        <div class="container table-responsive shadow p-5 mb-4">
            <h5 class="fs-5 fw-bold ">Recent Reports</h5>
            <hr>
            
            <ul class="nav nav-tabs" id="reportTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" id="crimeTab" data-bs-toggle="tab" data-bs-target="#crime" role="tab" aria-controls="crime" aria-selected="true">
                        <i class="bi bi-cone-striped"></i> Crime Report
                    </button>
                </li>
                
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" id="infraTab" data-bs-toggle="tab" data-bs-target="#infra" role="tab" aria-controls="infra" aria-selected="false">
                        <i class="bi bi-building"></i> Infrastructure Report   
                    </button>
                </li>
                
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" id="wasteTab" data-bs-toggle="tab" data-bs-target="#waste" role="tab" aria-controls="waste" aria-selected="false">
                        <i class="bi bi-trash"></i> Waste Report 
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="allfinishedreport">
                <div class="tab-pane fade show active" id="crime" role="tabpanel" aria-labelledby="crimeTab">
                    <div id='print1'>
                        <table class="table table-striped border mb-5">
                            <thead>
                                <tr>
                                    <th scope="col">Report ID</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Resolve Date</th>
                                    <th scope="col">Resolve Time</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $data['incident']->fetch_assoc()){?>
                                    <tr>
                                        <td><?=$row['reportnumber']?></td>
                                        <td><?=$row['reportcategory']?></td>
                                        <td><?=date('F d, Y',strtotime($row['resolvedate']))?></td>
                                        <td><?=date('h:i:s a',strtotime($row['resolvetime']))?></td>
                                        <td><?=$row['categorydescription']?></td>
                                    </tr>
                                <?php } ?>
                                  
                            </tbody>
                        </table>
                    </div>
                    
                    <button type="button" class="btn"id="pdf" onclick="printDiv('print1')"><i class="bi bi-printer"></i> Print</button> 
                    <button  class='btn' data-bs-toggle="modal" data-bs-target="<?='#wordpad' ?>"><i class="bi bi-pencil-square"></i> Write Summary</button>
                    <button class='btn' data-bs-toggle="modal" data-bs-target="<?='#viewcrime' ?>"><i class="bi bi-eye"></i>  View Saved Narrative</button>
                </div>
                
                <div class="tab-pane fade" id="infra" role="tabpanel" aria-labelledby="infraTab">
                    <div id='print2'>
                        <table class="table table-striped border mb-5">
                            <thead>
                                <tr>
                                    <th scope="col">Report ID</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Resolve Date</th>
                                    <th scope="col">Resolve Time</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $data['infrastructure']->fetch_assoc()){?>
                                    <tr>
                                        <td><?=$row['reportnumber']?></td>
                                        <td><?=$row['reportcategory']?></td>
                                        <td><?=date('F d, Y',strtotime($row['resolvedate']))?></td>
                                        <td><?=date('h:i:s a',strtotime($row['resolvetime']))?></td>
                                        <td><?=$row['categorydescription']?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <button type="button" class="btn"id="pdf" onclick="printDiv('print2')"><i class="bi bi-printer"></i> Print</button> 
                    <button  class='btn' data-bs-toggle="modal" data-bs-target="<?='#wordpad' ?>"><i class="bi bi-pencil-square"></i>Write Summary</button>
                    <button class='btn' data-bs-toggle="modal" data-bs-target="<?='#viewinfra' ?>"> <i class="bi bi-eye"></i> View Saved Narrative</button>
                </div>
    
                <div class="tab-pane fade" id="waste" role="tabpanel" aria-labelledby="wasteTab">
                    <div id='print3'>
                        <table class="table table-striped border mb-5">
                            <thead>
                                <tr>
                                    <th scope="col">Report ID</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Resolve Date</th>
                                    <th scope="col">Resolve Time</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $data['waste']->fetch_assoc()){?>
                                    <tr>
                                        <td><?=$row['reportnumber']?></td>
                                        <td><?=$row['category']?></td>
                                        <td><?=date('F d, Y',strtotime($row['resolvedate']))?></td>
                                        <td><?=date('h:i:s a',strtotime($row['resolvetime']))?></td>
                                        <td><?=$row['categoryDescription']?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <button type="button" class="btn"id="pdf" onclick="printDiv('print3')"><i class="bi bi-printer"></i> Print</button>  
                    <button  class='btn' data-bs-toggle="modal" data-bs-target="<?='#wordpad' ?>"><i class="bi bi-pencil-square"></i>Write Summary</button>
                    <button class='btn' data-bs-toggle="modal" data-bs-target="<?='#viewwaste' ?>"> <i class="bi bi-eye"></i> View Saved Narrative</button>
                </div>
            </div>
        </div>
                  <!---wordpad -->
           
                        <div class="modal fade" id="<?='wordpad' ?>" tabindex="-1" aria-labelledby="<?='additionalIncident'?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg model-dialog-center">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="blog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="<?='additionalIncident'?>">
                                               <i class="bi bi-pencil-square"></i> Write Narrative Report
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" >
                                            <label class="fs-5">Category:</label>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" name="drone" value="Crime" id="radioCrime" required>
                                                <label class="form-check-label" for="radioCrimet">Crime</label>
                                            </div>
                                            
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" name="drone" value="Infrastracture" id="radioInfra" required>
                                                <label class="form-check-label" for="radioInfra">Infrastracture</label>
                                            </div>
                                            
                                            <div class="form-check">
                                                <input type="radio"  class="form-check-input" name="drone" value="Waste" id="radioWaste" required>
                                                <label class="form-check-label" for="radioWaste">Waste</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="filename" class="form-control-label">File Name</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="filename" id="filename" aria-describedby="extension" required>
                                                    <span class="input-group-text" id="extension">.docx</span>
                                                </div>
                                            </div>
                                     	    <textarea class="form-control" id="word"  rows="20" name="content"  required> <p style="text-align: center;"><em>Republika ng Pilipinas</em></p>

<p style="text-align: center;"><strong>BARANGAY MASAMBONG&nbsp;</strong></p>

<p style="text-align: center;">TANGGAPAN NG PUNONG BARANGAY</p>

<p style="text-align: center;"><em>ika-1 Distrito, Lungsod Quezon</em></p><p></p></textarea>
                                     	    
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn" name="submit" value="Save Summary">
                                            <button type="reset" class="btn" id="reset" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        
        <!--Para sa Print Analytics -->       
        <div class="container border mb-4 p-5 shadow" id="reportChartMonthly" name="printReportChart">
            <div class="d-flex justify-content-end d-print-none">
                <h5 class="fs-4 fw-bold me-auto">Print Analytics</h5>
                <div class="col-sm-2">
                    <select class="form-select" id="selectDate">
                        <option selected disabled>Select Date</option>
                    </select>
                </div>
            </div>
            <img id="chartImg">
            <canvas class="d-print-none" id="monthlyReport"></canvas>
            <h5 class="fs-5 fw-bold text-center mt-4 mb-5" id="titleDate"></h5>
            <div class="d-flex d-print-none justify-content-end">
                <button type="button" class="btn" id="printChart"><i class="bi bi-printer"></i> Print</button>
            </div>
        </div>
                        
                        
                    </div>
                         

                  
                  <!---view notes-->
            
        
                   <div class="tab-pane show active" id="incidentPanel" role="tabpanel" aria-labelledby="incidentTab">
                
                <div class="d-flex flex-wrap p-3">
              
                  

                        <div class="modal fade" id="<?='viewcrime' ?>" tabindex="-1" aria-labelledby="<?='additionalIncident'?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg model-dialog-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="fs-5">
                                            <i class="bi bi-exclamation-circle"></i> Narrative Reports
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" >
                                        <form  method="post">
                             	            <table id="dash-table" class="table table-striped  table-hover table-responsive text-center align-middle">
							                    <thead>
							  	                    <tr>
							  		                    <th>No.</th>
							  		                    <th>NOTES</th>
							  	                    </tr>	
							                    </thead> 
							                    <tbody>
							                        <?php while($row = $narrative->fetch_assoc()){ ?>
    							                        <tr>
    							                            <td><?=$row['id']?></td>
    							                            <td><?=$row['category']?></td>
    							                            <td><?=$row['textarea_content']?></td>
    							                            
    							                            <td>
    							                                <a href="../view/printnote.php?print=<?=$row['id']?>" class="btn btn-info btn-xs">
    							                                    <i class="bi bi-eye"></i>View
    							                                </a>
    							                            </td>
    							                        </tr>
							                        <?php } ?>
							                    </tbody>
						                	</table>
                                        </form>  
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        
                                    </div>
                                </div>
                            </div>
                            <!---infra view note-->
                            <div class="modal fade" id="<?='viewinfra' ?>" tabindex="-1" aria-labelledby="<?='additionalIncident'?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg model-dialog-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="fs-5">
                                            <i class="bi bi-exclamation-circle"></i> Saved Summary Reports
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" >
                                        <form  method="post">
                             	            <table id="dash-table" class="table table-striped  table-hover table-responsive text-center align-middle">
							                    <thead>
							  	                    <tr>
							  		                    <th>No.</th>
							  		                    <th>NOTES</th>
							  	                    </tr>	
							                    </thead> 
							                    <tbody>
							                        <?php while($row = $narrative2->fetch_assoc()){ ?>
    							                        <tr>
    							                            <td><?=$row['id']?></td>
    							                             <td><?=$row['category']?></td>
    							                            <td><?=$row['textarea_content']?></td>
    							                            <td>
    							                                <a href="../view/printnote.php?print=<?=$row['id']?>" class="btn btn-info btn-xs">
    							                                    <i class="bi bi-printer"></i> Print
    							                                </a>
    							                            </td>
    							                        </tr>
							                        <?php } ?>
							                    </tbody>
						                	</table>
                                        </form>  
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <!---waste view note-->
                            <div class="modal fade" id="<?='viewwaste' ?>" tabindex="-1" aria-labelledby="<?='additionalIncident'?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg model-dialog-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="fs-5">
                                            <i class="bi bi-exclamation-circle"></i> Saved Summary Reports
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" >
                                        <form  method="post">
                             	            <table id="dash-table" class="table table-striped  table-hover table-responsive text-center align-middle">
							                    <thead>
							  	                    <tr>
							  		                    <th>No.</th>
							  		                    <th>NOTES</th>
							  	                    </tr>	
							                    </thead> 
							                    <tbody>
							                        <?php while($row = $narrative3->fetch_assoc()){ ?>
    							                        <tr>
    							                            <td><?=$row['id']?></td>
    							                             <td><?=$row['category']?></td>
    							                            <td><?=$row['textarea_content']?></td>
    							                            <td>
    							                                <a href="../view/printnote.php?print=<?=$row['id']?>" class="btn btn-info btn-xs">
    							                                    <i class="bi bi-printer"></i>Print
    							                                </a>
    							                            </td>
    							                        </tr>
							                        <?php } ?>
							                    </tbody>
						                	</table>
                                        </form>  
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                   
                </div>
                
            </div>


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

   
   
<!----------- print/pdf ----------->
<script>
		function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
		     var b = "<p>BARANGAY MASAMBONG OFFICIAL</p>"
             var a = "<p>Generated by: Jasmine B. Motin - The Barangay Secretary</p>"

			document.body.innerHTML =b+a+ printContents;

			window.print();

			document.body.innerHTML = originalContents;

		}
	</script>
<!---------- Print Chart ------------->
	
	
<!-- save doc -->
<script>
    function exportHTML2(){
        
         var x = tinymce.get("wor").getContent();
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head>  <br>";
       var footer = "</html>";
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
<script type="text/javascript">
$( document ).ready(function() {
$('#employee_grid').DataTable({
		 "processing": true,
         "sAjaxSource":"response.php",
		 "dom": 'lBfrtip',
		 "buttons": [
            {
                extend: 'collection'
                
            }
        ]
        });
});
</script>
     
    </div>

<!----------- Footer ----------->    
<script src="../resources/chart.js" type="text/javascript"></script>
<?php include '../resources/footer/footer.php' ?>