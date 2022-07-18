<?php 
    require '../controller/userController.php';
    
    session_start();
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }
    
    $controller = new UserController();
    $data = $controller->Verified();
    
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
    #myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 20%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
</style>
<body style="background-image: url('../resources/files/background.png'); background-repeat: none; background-position: fixed; background-position: center;">
    <div class="container shadow mt-5 p-5">
        <div  class="table-responsive">
            <h4 class="fs-5 fw-bold mb-4">Verified Residents Account</h4>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
            <table style="overflow-y:auto;" id="tableD" class="table table-striped table-hover border text-center">
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
                                            <img src="<?php if(!empty($row['selfie'])){  echo '/../Registration/'.$row['selfie']; }else{ echo '../resources/files/background.png'; } ?>" width="30%">
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="fs-6 fw-bold">Valid ID</h6>
                                            <img src="<?php if(!empty($row['idphoto'])){  echo '/../Registration/'.$row['idphoto']; }else{ echo '../resources/files/background.png'; } ?>" width="60%">
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
                            <button type="button" class="btn btn-sm" name="remove" value="<?=$row['id']?>"><i class="bi bi-trash"> Delete </i></button> 
                                        </div>
                                    </div>
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
         //Remove Single Log
        
        $('button[name="remove"]').on('click',function(){
            var id = $(this).val();
            console.log(id)
            var remove = $.ajax({
                type: "GET",
                url: '../process/removeaccount.php',
                data:{ 
                    id:id
                    
                }
            })
            
            remove.done(function(data){
                location.reload()
                console.log(data)
            })
        })
    })
</script>

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tableD tr ").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<?php /**<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("tableD");
  td = table.getElementsByTagName("td");
  tr = table.getElementsByTagName("tr");
  
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
**/?>



<!----------- Footer ----------->  
<?php include '../resources/footer/footer.php' ?>