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
    $data = $controller->getOngoing();



?>
<!----------- Header ----------->
<?php include '../resources/header/header.php' ?>
<?php include '../resources/header/navigation.php' ?>


<!----------- Main Body ----------->
<body style="background-image: url('../resources/files/background.png'); background-repeat: none; background-position: fixed; background-position: center;">
    <div class="container-fluid shadow mt-5 p-5"><h1>ON-GOING REPORTS</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="incidentTab" data-bs-toggle="tab" data-bs-target="#incidentPanel" type="button" role="tab" aria-control="incidentPanel" aria-selected="true">Crime Reports</button>
                <button class="nav-link" id="infraTab" data-bs-toggle="tab" data-bs-target="#infraPanel" type="button" role="tab" aria-control="infraPanel" aria-selected="false" >Infrastructure Reports</button>
                <button class="nav-link" id="wasteTab" data-bs-toggle="tab" data-bs-target="#wastePanel" type="button" role="tab" aria-control="wastePanel" aria-selected="false">Waste Reports</button>
            </div>
        </nav>
        
        <div class="tab-content" id="reportTabs">

            <!------------ Incident Report ------------>
        
            <div class="tab-pane show active" id="incidentPanel" role="tabpanel" aria-labelledby="incidentTab">
                <span class="text-center"><h5 class="fs-5 fw-bolder mt-4"><?php if($data['incident']->num_rows == 0){echo 'No Pending Reports';} ?></h5></span>
                <div class="d-flex flex-wrap p-3">
                    <?php while($row = $data['incident']->fetch_assoc()){ ?>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <div class="card me-3 mb-5 border p-2" id="report">
                                <div class="text-center">
                                    <?php   $crimeImg = '../../IncidentReport/'.$row['reportimg']; 
                                            if(!file_exists($crimeImg) || empty($row['reportimg'])){ ?>
                                                <img src="../resources/files/background.png" alt="Report Image" class="card-img-top">
                                    <?php   }else{ ?>
                                                <img src="<?=$crimeImg?>" alt="Report Image" class="card-img-top" >
                                    <?php   } ?>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><p class="card-title" name="reportID"><label class="fw-bold">Report ID :</label><?= ' '.$row['reportnumber']; ?></p></li>
                                        <li><p class="card-text"><label class="fw-bold">Category :</label><?= ' '.$row['reportcategory']; ?></p></li>
                                          <li><p><label class="fw-bold">Date of Incident: </label><?= ' '.$row['DateofIncident']; ?></p></li>
                                            <li><p><label class="fw-bold">Report Time: </label><?= ' '.$row['reporttime']; ?></p></li>
                                            <li><p><label class="fw-bold">Report Date: </label><?= ' '.$row['reportdate']; ?></p></li>
                                        <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['resolvestatus']?></p></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <button class="btn form-control" data-bs-toggle="modal" data-bs-target="<?='#additionalIncidentModal'.$row['reportnumber']; ?>">
                                        <i class="bi bi-eye"></i> View Status
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
                                    <div class="modal-body">
                                        <ul class="list-unstyled">
                                            <?php   $crimeImg = '../../IncidentReport/'.$row['reportimg']; 
                                                    if(!file_exists($crimeImg) || empty($row['reportimg'])){?>
                                                        <img src="../resources/files/background.png" alt="Proof" width="100%"  >
                                            <?php   }else{ ?>
                                                        <img src="<?=$crimeImg?>" alt="Proof" width="100% " >
                                            <?php   } ?>
                                            
                                            <li><p><label class="fw-bold">Reporter's Name: </label><?=' '.$row['reportername']; ?></p></li>
                                            <li><p><label class="fw-bold">Location: </label><?= ' '.$row['reportlocation']; ?></p></li>
                                            <li><p class="card-text"><label class="fw-bold">Category Description :</label><?= ' '.$row['categorydescription']; ?></p></li>
                                            <li><p><label class="fw-bold">Report Description: </label><?= ' '.$row['reportdescription']; ?></p></li>
                                        
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!------------ Infrastructure Reports ------------>

            <div class="tab-pane" id="infraPanel" role="tabpanel" aria-labelledby="infraTab">
            <span class="text-center"><h5 class="fs-5 fw-bolder mt-4"><?php if($data['infrastructure']->num_rows == 0){echo 'No Pending Reports';} ?></h5></span>
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
                                             <li><p><label class="fw-bold">Report Date: </label><?= ' '.$row['reportdate']; ?></p></li>
                                            <li><p><label class="fw-bold">Report TIme: </label><?= ' '.$row['reporttime']; ?></p></li>
                                        <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['resolvestatus']?></p></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <button class="btn form-control" data-bs-toggle="modal" data-bs-target="<?='#additionalInfraModal'.$row['reportnumber']; ?>">
                                        <i class="bi bi-eye"></i> View Status
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
                                    <div class="modal-body">
                                        <ul class="list-unstyled">
                                            
                                            <?php   $infraImg = '../../Infrastracture/'.$row['reportimg']; 
                                                    if(!file_exists($infraImg) || empty($row['reportimg'])){?>
                                                        <img src="../resources/files/background.png" alt="Proof" width="100%">
                                            <?php   }else{ ?>
                                                        <img src="<?=$infraImg?>" alt="Proof" width="100%">
                                            <?php   } ?>
                                            
                                            <li><p><label class="fw-bold">Reporter's Name: </label><?=' '.$row['reportername']; ?></p></li>
                                            <li><p><label class="fw-bold">Location: </label><?= ' '.$row['reportlocation']; ?></p></li>
                                            <li><p class="card-text"><label class="fw-bold">Category Description :</label><?= ' '.$row['categorydescription']; ?></p></li>
                                            <li><p><label class="fw-bold">Description: </label><?= ' '.$row['reportdescription']; ?></p></li>
                                       
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!------------ Waste Reports ------------>

            <div class="tab-pane" id="wastePanel" role="tabpanel" aria-labelledby="wasteTab">
            <span class="text-center"><h5 class="fs-5 fw-bolder mt-4"><?php if($data['waste']->num_rows == 0){echo 'No Pending Reports';} ?></h5></span>
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
                                         <li><p><label class="fw-bold">Report Date: </label><?= ' '.$row['dateReported']; ?></p></li>
                                         
                                        <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['status']; ?></p></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <button class="btn form-control" data-bs-toggle="modal" data-bs-target="<?='#additionalWasteModal'.$row['reportnumber']; ?>">
                                        <i class="bi bi-eye"></i> View Status
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
                                    <div class="modal-body">
                                        <ul class="list-unstyled">
                                            <?php   $wasteImg = '../../Wastereport/'.$row['photo']; 
                                                    if(!file_exists($wasteImg) || empty($row['photo'])){?>
                                                        <img src="../resources/files/background.png" alt="Proof" width="100%">
                                            <?php   }else{ ?>
                                                        <img src="<?=$wasteImg?>" alt="Proof" width="100%">
                                            <?php   } ?>
                                            <li><p><label class="fw-bold">Reporter's Name: </label><?=' '.$row['firstname'].$row['lastname']; ?></p></li>
                                            <li><p><label class="fw-bold">Location: </label><?= ' '.$row['location']; ?></p></li>
                                            <li><p><label class="fw-bold">Category Description: </label><?= ' '.$row['categoryDescription']; ?></p></li>
                                            <li><p><label class="fw-bold">Description: </label><?= ' '.$row['Description']; ?></p></li>
                                            <hr class="mb-3 mt-3">
                                            <li><p><label class="fw-bold">Date Responded: </label><?=' '.$row['respondate']?></p></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
    
  
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>