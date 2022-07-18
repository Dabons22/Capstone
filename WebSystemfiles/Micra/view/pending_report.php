<?php

    session_start();
    require '../controller/tableController.php';

    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }
    
    if($_SESSION['position'] == 'Main Administrator' or $_SESSION['position'] == 'Barangay Chairman'){
        header('Location: index.php');
    }

    $controller = new TableController();
    $data = $controller->getPending();

    $table = '';
    $sendto = '';
    switch($_SESSION['position']){
        case 'Crime Head':
            $table = $data['incident'];
            $sendto = '../process/acceptIncident.php';
            break;
        case 'Waste Head':
            $table = $data['waste'];
            $sendto = '../process/acceptWaste.php';
            break;
        case 'Infrastructure Head':
            $table = $data['infrastructure'];
            $sendto = '../process/acceptInfra.php';
            break;
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
    <div class="container-fluid shadow mt-5 p-5">
        <div class="d-flex justify-content-end me-2">
            <div class="col">
                <button type="button" class="btn" id="grid"><i class="bi bi-grid"></i></button>
                <button type="button" class="btn" id="list"><i class="bi bi-list-task"></i></button>
            </div>
            <div class="d-flex" id="searchContainer">
                <div class="yeah col-sm-8 mb-5 me-2">
                    <input type="text" class="form-control form-control-sm" id="searchBar" placeholder="Search Report" required>
                </div>
                <div class="yeah col">
                    <button type="submit" class="btn btn-sm" id="search"><i class="bi bi-search"></i> Search</button>
                </div>
            </div>
        </div> 
        <h1 class="fs-3 fw-bold">PENDING REPORTS</h1>
        <hr> 
        <span class="text-center"><h5 class="fs-5 fw-bolder mt-4"><?php if($table->num_rows == 0){echo 'No Pending Reports';} ?></h5></span>
        <div class="allReportGrid">
            <div class="d-flex flex-wrap" id="searchedReport"></div>
            <div class="d-flex flex-wrap" id="report">
                <?php while($row = $table->fetch_assoc()){ ?>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                        <div class="card me-3 mb-5 border p-2">
                            <div class="text-center">
                                <?php switch($_SESSION['position']){
                                        case 'Waste Head': 
                                            $wasteImg = '../../Wastereport/'.$row['photo']; 
                                            if(!file_exists($wasteImg) || empty($row['photo'])){?>
                                                <img src="../resources/files/background.png" alt="Report Image" class="card-img-top">
                                    <?php   }else{ ?>
                                                <img src="<?=$wasteImg?>" alt="Report Image" class="card-img-top">
                                    <?php   }
                                            break;
                                        case 'Crime Head':                                         
                                            $crimeImg = '../../IncidentReport/'.$row['reportimg']; 
                                            if(!file_exists($crimeImg) || empty($row['reportimg'])){?>
                                                <img src="../resources/files/background.png" alt="Report Image" class="card-img-top">
                                    <?php   }else{ ?>
                                                <img src="<?=$crimeImg?>" alt="Report Image" class="card-img-top">
                                    <?php   }
                                            break;
                                        case 'Infrastructure Head':                                            
                                            $infraImg = '../../Infrastracture/'.$row['reportimg']; 
                                            if(!file_exists($infraImg) || empty($row['reportimg'])){?>
                                                <img src="../resources/files/background.png" alt="Report Image" class="card-img-top">
                                    <?php   }else{ ?>
                                                <img src="<?=$infraImg?>" alt="Report Image" class="card-img-top">
                                    <?php   }
                                            break;
                                    } ?>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li><p class="card-title" name="reportID"><label class="fw-bold">Report ID :</label><?= ' '.$row['reportnumber']; ?></p></li>
                                    
                                    <?php if($_SESSION['position'] != 'Waste Head'){ ?>                                    
                                        <li><p class="card-text"><label class="fw-bold">Category :</label><?= ' '.$row['reportcategory']; ?></p></li>
                                    <?php }else{ ?>
                                        <li><p class="card-text"><label class="fw-bold">Category :</label><?= ' '.$row['category']; ?></p></li>
                                    <?php }?>
                                    
                                      <?php if($_SESSION['position'] != 'Waste Head'){ ?>                                    
                                        <li><p class="card-text"><label class="fw-bold">Report Date :</label><?= ' '.$row['reportdate']; ?></p></li>
                                    <?php }else{ ?>
                                        <li><p class="card-text"><label class="fw-bold">Report Date:</label><?= ' '.$row['dateReported']; ?></p></li>
                                    <?php }?>
                                    
                                      <?php if($_SESSION['position'] != 'Waste Head'){ ?>                                    
                                        <li><p class="card-text"><label class="fw-bold">Report Time :</label><?= ' '.$row['reporttime']; ?></p></li>
                                    <?php }else{ ?>
                                        <li><p class="card-text"><label class="fw-bold">Report Time :</label><?= ' '.$row['dateReported']; ?></p></li>
                                    <?php }?>
                                    
                                    <?php if($_SESSION['position'] != 'Waste Head'){ ?>                                    
                                        <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['resolvestatus']?></p></li>
                                    <?php }else{ ?>
                                        <li><p class="card-text"><label class="fw-bold">Status :</label><?= ' '.$row['status']?></p></li>
                                    <?php }?>
                                    
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
                                        <?php switch($_SESSION['position']){
                                        case 'Waste Head': 
                                            $wasteImg = '../../Wastereport/'.$row['photo']; 
                                            if(!file_exists($wasteImg) || empty($row['photo'])){?>
                                                <img src="../resources/files/background.png" alt="Proof" width="100%">
                                    <?php   }else{ ?>
                                                <img src="<?=$wasteImg?>" alt="Proof" width="100%">
                                    <?php   }
                                            break;
                                        case 'Crime Head':                                         
                                            $crimeImg = '../../IncidentReport/'.$row['reportimg']; 
                                            if(!file_exists($crimeImg) || empty($row['reportimg'])){?>
                                                <img src="../resources/files/background.png" alt="Proof" width="100%">
                                    <?php   }else{ ?>
                                                <img src="<?=$crimeImg?>" alt="Proof" width="100%">
                                    <?php   }
                                            break;
                                        case 'Infrastructure Head':                                            
                                            $infraImg = '../../Infrastracture/'.$row['reportimg']; 
                                            if(!file_exists($infraImg) || empty($row['reportimg'])){?>
                                                <img src="../resources/files/background.png" alt="Proof" width="100%">
                                    <?php   }else{ ?>
                                                <img src="<?=$infraImg?>" alt="Proof" width="100%">
                                    <?php   }
                                            break;
                                    } ?>
                                        
                                        <?php if($_SESSION['position'] != 'Waste Head'){ ?>                                    
                                            <li><p><label class="fw-bold">Reporter's Name: </label><?=' '.$row['reportername']; ?></p></li>
                                        <?php }else{ ?>
                                            <li><p><label class="fw-bold">Reporter's Name: </label><?=' '.$row['firstname'].' '.$row['lastname']; ?></p></li>
                                        <?php }?>
                                        
                                        
                                        <?php if($_SESSION['position'] != 'Waste Head'){ ?>                                    
                                            <li><p><label class="fw-bold">Location: </label><?= ' '.$row['reportlocation']; ?></p></li>
                                        <?php }else{ ?>
                                            <li><p><label class="fw-bold">Location: </label><?= ' '.$row['location']; ?></p></li>
                                        <?php }?>
                                        
                                        <?php if($_SESSION['position'] != 'Waste Head'){ ?>                                    
                                        <li><p class="card-text"><label class="fw-bold">Category Description :</label><?= ' '.$row['categorydescription']; ?></p></li>
                                    <?php }else{ ?>
                                        <li><p class="card-text"><label class="fw-bold">Category Description :</label><?= ' '.$row['categoryDescription']; ?></p></li>
                                    <?php }?>
                                    
                                        <?php if($_SESSION['position'] != 'Waste Head'){ ?>                                    
                                            <li><p><label class="fw-bold">Report Description: </label><?= ' '.$row['reportdescription']; ?></p></li>
                                        <?php }else{ ?>
                                            <li><p><label class="fw-bold">Report Description: </label><?= ' '.$row['Description']; ?></p></li>
                                        <?php }?>
                                        
                                        <?php if($_SESSION['position'] == 'Crime Head'){ ?>
                                            <li><p><label class="fw-bold">Date of Incident: </label><?= ' '.$row['DateofIncident']; ?></p></li>
                                        <?php } ?>
                                        
                                        
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#respond<?=$row['reportnumber']?>">
                                        <i class="bi bi-send"></i>Send Respond
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" data-bs-backdrop="static" id="respond<?=$row['reportnumber']?>" tabindex="-1" aria-label="Send Response" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="bi bi-envelope"></i> Send Response</h5>
                                </div>
                                <form method="POST" action="<?=$sendto?>">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <?php if($_SESSION['position'] != 'Waste Head'){ ?>
                                                <input type="hidden" name="user" value="<?=$row['reporteruserid']?>">
                                            <?php }else{ ?> 
                                                <input type="hidden" name="user" value="<?=$row['userid']?>">
                                            <?php } ?>
                                            <label for="message" class="col-form-label">Response</label>
                                            <textarea class="form-control" id="message" name="message" placeholder="Response Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn" data-bs-toggle="modal" data-bs-target="#additionalModal<?=$row['reportnumber']?>">Cancel</button>
                                        <button type="submit" class="btn" name="accept" value="<?=$row['reportnumber']?>"><i class="bi bi-send"></i> Respond</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                <?php } ?>
            </div>
        </div>
        <div class="allReportList">
            <div class="table-responsive">
                <table class="table" id="reportTable">
                    <thead>
                        <tr>
                            <th scope="col">R.I</th>
                            <th scope="col">Category</th>
                            <th scope="col">Report Date</th>
                            <th scope="col">Report Time</th>
                            <th scope="col">Status</th>
                        </tr>    
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


<script>
    $('.allReportList').hide()
    $('#grid').addClass('disabled')
    $(document).ready(function(){
        
        $('#reportTable').DataTable()
        
        $('#message').each(function(){
        this.setAttribute('style','height:' +(this.scrollHeight) +'px;overflow-y:hidden')
        }).on('input',function(){
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        })

        /*$('#searchBar').on('keyup',function(){
            var value = $(this).val().toLowerCase()
            

            $("div[class^=col-sm-12]").hide().filter(function(){
                var cardTitle = $(this).find('.card-title').text().toLowerCase()

                return cardTitle.includes(value)
            }).show()
        })*/
        
        
        $('#search').click(function(){
            var searchFor = $('#searchBar').val()
            
            if(searchFor !== ''){
                $.ajax({
                    url: '../process/searchReport.php',
                    method: 'POST',
                    data: {
                        search:searchFor,
                        table: 'tblincident'
                    },
                    success: function(data){
                        $('.card').hide()
                        $('#searchedReport').html(data)
                    }
                })
            }

        })
        
        $('#grid').on('click',function(){
            $(this).addClass('disabled')
            $('#list').removeClass('disabled')
            $('.allReportGrid').show()
            $('.allReportList').hide()
            $('.yeah').show()
        })
        
        $('#list').on('click',function(){
            $(this).addClass('disabled')
            $('#grid').removeClass('disabled')
            $('.allReportList').show()
            $('.allReportGrid').hide()
            $('.yeah').hide()
        })
    })
</script>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>