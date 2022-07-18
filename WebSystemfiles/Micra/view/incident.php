<?php 

    require '../controller/tableController.php';

    session_start();
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }
    
    if($_SESSION['position'] == 'Main Administrator' or $_SESSION['position'] == 'Barangay Chairman'){
        header('Location: index.php');
    }


    $controller = new TableController();
    $data = $controller->getOngoing();

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
    <div class="container-fluid shadow mt-5 p-5">
    <div class="d-flex justify-content-end">
            <div class="col-sm-2 mb-5">
                <input type="text" class="form-control form-control-sm" id="searchBar" placeholder="Search Report ID">
            </div>
        </div><h1>ON-GOING REPORTS</h1>
        <hr>
        <span class="text-center"><h5 class="fs-5 fw-bolder mt-4"><?php if($data['incident']->num_rows == 0){echo 'No Ongoing Reports';} ?></h5></span>
        <div class="d-flex flex-wrap" id="report">
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
                                <li><p class="card-text"><label class="fw-bold">Category Description :</label><?= ' '.$row['categorydescription']; ?></p></li>
                                <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['resolvestatus']?></p></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <button class="btn form-control" data-bs-toggle="modal" data-bs-target="<?='#additionalModal'.$row['reportnumber']; ?>">
                                <i class="bi bi-eye"></i> View
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="<?='additionalModal'.$row['reportnumber'] ?>" tabindex="-1" aria-labelledby="<?='additional'.$row['reportnumber']?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg model-dialog-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="<?='additional'.$row['reportnumber']?>">
                                    <i class="bi bi-exclamation-circle"></i> Additional Details
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-unstyled">
                                <?php   $crimeImg = '../../IncidentReport/'.$row['reportimg']; 
                                        if(!file_exists($crimeImg) || empty($row['reportimg'])){?>
                                            <img src="../resources/files/background.png" alt="Proof" width="100%">
                                <?php   }else{ ?>
                                            <img src="<?=$crimeImg?>" alt="Proof" width="100%">
                                <?php   } ?>
                                
                                    <li><p><label class="fw-bold">Reporter's Name: </label><?=' '.$row['reportername']; ?></p></li>
                                    <li><p><label class="fw-bold">Location: </label><?= ' '.$row['reportlocation']; ?></p></li>
                                    <li><p><label class="fw-bold">Report Description: </label><?= ' '.$row['reportdescription']; ?></p></li>
                                    <li><p><label class="fw-bold">Date of Incident: </label><?= ' '.$row['DateofIncident']; ?></p></li>
                                    <li><p><label class="fw-bold">Report Time: </label><?= ' '.$row['reporttime']; ?></p></li>
                                    <li><p><label class="fw-bold">Report Date: </label><?= ' '.$row['reportdate']; ?></p></li>
                                    <hr class="mb-3 mt-3">
                                    <li><p><label class="fw-bold">Date Responded: </label><?=' '.$row['repondate']?></p></li>
                                    <li><p><label class="fw-bold">Time Responded: </label><?=' '.$row['respondtime']?></p></li>
                                    <li><p><label class="fw-bold">Responded By: </label><?=' '.$row['respondername']?></p></li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" data-bs-target="<?='#feedbackModal'.$row['reportnumber']; ?>" data-bs-toggle="modal">
                                    <i class="bi bi-send"></i> Finish Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="<?='feedbackModal'.$row['reportnumber']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" aria-labelledby="<?='feedBack'.$row['reportnumber']?>">
                    <div class="modal-dialog modal-md modal-dialog-center">
                        <div class=modal-content>
                            <div class="modal-header">
                                <h5 class="modal-title" id="<?='feedBack'.$row['reportnumber']?>">
                                    <i class="bi bi-envelope"></i> Send Feedback
                                </h5>
                            </div>
                            <form method="POST" action="../process/finishIncident.php">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <input type="hidden" name="id" value='<?= $row['reportnumber']; ?>'>
                                        <input type="hidden" name="user" value="<?=$row['reporteruserid']?>">
                                        <label for="message" class="col-form-label">Feedback</label>
                                        <textarea class="form-control" id="message" placeholder="Optional" name="message"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="reset" class="btn" id="otherButton" role="button" data-bs-target="<?='#additionalModal'.$row['reportnumber']?>" data-bs-toggle="modal" value="Cancel">
                                    <button type="submit" class="btn" name="submit" value="send"><i class="bi bi-send"></i> Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>




    </div>


<script>
    $(document).ready(function(){
        $('#message').each(function(){
        this.setAttribute('style','height:' +(this.scrollHeight) +'px;overflow-y:hidden')
        }).on('input',function(){
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        })

        $('#searchBar').on('keyup',function(){
            var value = $(this).val().toLowerCase()
            

            $("div[class^=col-sm-12]").hide().filter(function(){
                var cardTitle = $(this).find('.card-title').text().toLowerCase()

                return cardTitle.includes(value)
            }).show()
        })
    })
</script>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>