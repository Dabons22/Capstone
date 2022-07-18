<?php 
    require '../controller/userController.php';
    
    session_start();
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }
    
    $controller = new UserController();
    $data = $controller->getNotVerified();
    
    $err = "";
    
    if($data->num_rows === 0){
        $err="No Records";
    }
?>

<!----------- Header ----------->
<?php include '../resources/header/header.php' ?>
<?php include '../resources/header/navigation.php' ?>

<!----------- Main Body ----------->
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
<body style="background-image: url('../resources/files/background.png'); background-repeat: none; background-position: fixed; background-position: center;">
    <div class="container shadow mt-5 p-5">
        <div class="table-responsive">
            <h4 class="fs-5 fw-bold mb-4">For Verification</h4>
            <table class="table table-striped table-hover border text-center">
                <thead class="header">
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Firstname</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <!----------- Table Data ----------->
                <tbody id="tableData">
                    <?php while($row = $data->fetch_assoc()){ ?>
                        <tr>
                            <td><?=$row['id'] ?></td>
                            <td><?=$row['firstname'] ?></td>
                            <td><?=$row['lastname'] ?></td>
                            <td><button class="btn btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#user<?=$row['id']?>">View Info</button></td>
                            
                            <div class="modal fade" id="user<?=$row['id']?>" tabindex="-1" aria-labelledby="labelUser<?=$row['id']?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="bi bi-images"></i> User Information</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <input type="hidden" value="<?=$row['email']?>" name="email">
                                                        <input type="hidden" value="<?=$row['number']?>" name="phone">
                                                        <input type="hidden" value="<?=$row['']?>" name="email">
                                                        <input type="hidden" value="<?=$row['number']?>" name="phone">
                                                        
                                        <div class="modal-body">
                                            <h6 class="fs-6 fw-bold">Selfie</h6>
                                            <img id="myImg" src="<?php if(!empty($row['selfie'])){  echo '/../Registration/'.$row['selfie']; }else{ echo '../resources/files/background.png'; } ?>" width="30%">
                                            <div id="myModal1" class="modal1">
  <span class="close">&times;</span>
  <img class="modal-content1" id="img01">
  <div id="caption"></div>
</div>
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="fs-6 fw-bold">Valid ID</h6>
                                            <img id="myImg" src="<?php if(!empty($row['idphoto'])){  echo '/../Registration/'.$row['idphoto']; }else{ echo '../resources/files/background.png'; } ?>" width="60%">

                                        </div>
                        <div id="myModal1" class="modal1">
  <span class="close">&times;</span>
  <img class="modal-content1" id="img01">
  <div id="caption"></div>
</div>
                                        <div class="modal-body row">
                                                <label class="fs-6 fw-bold">User Name</label>
                                                <h6 class="fs-6"><?= $row['username']?> </h6>
                                            </div>
                                       <div class="modal-body row">
                                                <label class="fs-6 fw-bold">Number</label>
                                                <h6 class="fs-6"><?= $row['number']?> </h6>
                                            </div>
                                          <div class="modal-body row">
                                                <label class="fs-6 fw-bold">Email</label>
                                                <h6 class="fs-6"><?= $row['email']?> </h6>
                                            </div>
                                            <div class="modal-body row">
                                                <label class="fs-6 fw-bold"> Name</label>
                                                <h6 class="fs-6"><?= $row['firstname'] . $row['middlename'] . $row['lastname']?>  </h6>
                                            </div>
                                                 <div class="modal-body row">
                                                <label class="fs-6 fw-bold">Birthdate</label>
                                                <h6 class="fs-6"><?= $row['birthdate']?> </h6>
                                            </div>
                                               <div class="modal-body row">
                                                <label class="fs-6 fw-bold">Gender</label>
                                                <h6 class="fs-6"><?= $row['gender']?> </h6>
                                            </div>
                                            <div class="modal-body row">
                                                <label class="fs-6 fw-bold">Address</label>
                                                <h6 class="fs-6"><?= $row['address']?> </h6>
                                            </div>
                                            
                                        <div class="modal-footer">
                                            <button type="button" class="btn" name="reject" data-bs-toggle="modal" data-bs-target="#userReject<?=$row['id']?>"><i class="bi bi-x"></i> Reject</button>
                                            <form method="post" action="../process/acceptUser.php">
                                                <button type="submit" class="btn" name="accept" value="<?=$row['id']?>"><i class="bi bi-check2"></i> Accept</button>
                                                <input type="hidden" value="<?=$row['email']?>" name="email">
                                            <input type="hidden" value="<?=$row['number']?>" name="number">
                                                        
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal fade" id="userReject<?=$row['id']?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="reject<?=$row['id']?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="post" action="../process/rejectUser.php">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reject ?</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="hidden" value="<?=$row['email']?>" name="email">
                                                        <input type="hidden" value="<?=$row['number']?>" name="phone">

                                                        <input type="checkbox" name="respond[]" class="form-check-input" id="invalidID" value="Invalid ID">
                                                        <label class="form-check-label" for="invalidID">Invalid ID</label>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="checkbox" name="respond[]"class="form-check-input" id="lowResolution" value="Low Resolutin Image">
                                                        <label class="form-check-label" for="lowResolution">Low Resolution Image</label>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="checkbox" name="respond[]" class="form-check-input" id="noImage" value="No Image Attached">
                                                        <label class="form-check-label" for="noImage">No Image Attached</label>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <input type="checkbox" name="respond[]"class="form-check-input" id="noValidID" value="No Valid ID Attached">
                                                        <label class="form-check-label" for="noValidID">No Valid ID Attached</label>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="modal-body">
                                                <label for="optionalMessage">Optional Message</label>
                                                <textarea class="form-control" name="optionalMessage" id="optionalMessage" placeholder="Optional Message"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="reset" class="btn" data-bs-toggle="modal" data-bs-target="#user<?=$row['id']?>">Cancel</button>
                                                <button type="submit" class="btn" value="<?=$row['id']?>" name="sendReject">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
            <span class="text-center"><h6 class="fs-6 fw-bold"><?=$err?></h6></span>
        </div>
    </div>
<script>
    $(document).ready(function(){
        $('#optionalMessage').each(function(){
            this.setAttribute('style','height:' +(this.scrollHeight) +'px;overflow-y:hidden')
            }).on('input',function(){
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
        })
    })
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
<?php include '../resources/footer/footer.php' ?>