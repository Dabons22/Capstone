<?php
    require '../controller/adminController.php';
    session_start();
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }

    $controller = new AdminController;
    $data = $controller->getAccount();

?>
<!----------- Header ----------->
<?php include '../resources/header/header.php' ?>
<?php include '../resources/header/navigation.php' ?>

<!----------- Main Body ----------->
<body>
    <div class="container p-5 shadow mb-3">
        <h4 class="fs-5 fw-bold mb-4">Create new Admin Account</h4>
        <div class="container border border-2 p-3">
            <form id="addAdmin">
                <div class="row mb-3">
                    <div class="col">
                        <label for="firstname" class="form-label">Firstname</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Pangalan" required>
                    </div>
                    <div class="col">
                        <label for="lastname" class="form-label">Lastname</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Apelyido" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="position" class="form-label">Position</label>
                        <select class="form-select" id="position" name="position">
                            <option value="Main Administrator">Admin</option>
                            <option value="Incident Head">Crime Head</option>
                            <option value="Infrastructure Head">Infrastructure Head</option>
                            <option value="Waste Head">Waste Head</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="email" class="form-label">Email</label>
                        <span id="emailerror"></span>
                        <input type="email" class="form-control" name="email" id="email" placeholder="example@micra.com" required>
                    </div>
                    <div class="col">
                        <label for="contact" class="form-label">Contact Number</label>
                        <span id="contacterror"></span>
                        <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact Number" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="username" class="form-label">Username</label>
                        <span id="usernameerror"></span>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Your Username" required>
                    </div>
                    <div class="col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" minlength="8" maxlength="16" class="form-control" name="password" id="password" placeholder="Minimum of 8 characters and maximum of 16 characters." autocomplete="off" required>
                    </div>
                </div>
                <button type="submit" class="btn form-control form-control-lg" name="submit" id="submit" value="subit">Create Account</button>
            </form>
        </div>
    </div>
    
        <div class="container shadow mt-4 p-5">
        <h4 class="fs-5 fw-bold mb-4">List of Admins</h4>
        <div id="allAccounts">
        <div class="accordion" id="permissions">
            <?php while($row = $data->fetch_assoc()){ ?>
            <div class="accordion-item">
                <h5 class="accordion-header" id="account<?=$row['ID']?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#adminAccount<?=$row['ID']?>" aria-expanded="false" aria-controls="adminAccount<?=$row['ID']?>">
                        <?= $row['USERNAME']?>
                    </button>
                </h5>
                <div id="adminAccount<?=$row['ID']?>" class="accordion-collapse collapse" aria-labelledby="account<?=$row['ID']?>" data-bs-parent="#permissions">
                    <div class="accordion-body">
                        <div class="p-4 border mb-3">
                            <div class="d-flex">
                                <?php 
                                    $image = $row['USERPHOTO'];
                                    $imageDir = '../resources/files/user/'.$image;
                                    
                                    if(!file_exists($imageDir) || empty($row['USERPHOTO'])){
                                        $imageDir = '../resources/files/user.png';
                                    }
                                ?>
                                <div class="col-sm-2 text-center">
                                    <img src="<?=$imageDir?>"  style="max-width: 100%">
                                </div>
                                <div class="col-sm-10">
                                    <h5 class="fs-6">Name :<?=' '.$row['FULLNAME']?> </h5>
                                    <h5 class="fs-6">Email :<?=' '.$row['EMAIL']?></h5>
                                    <h5 class="fs-6">Contact :<?=' '.$row['CONTACT']?></h5>
                                    <div class="col-3" name="editPosition" id="editPosition<?=$row['ID']?>" style="display: none;">
                                        <select class="form-select form-select-sm" aria-label="Position" id="select<?=$row['ID']?>">
                                            <option value="Main Administrator" selected>Administrator</option>
                                            <option value="Waste Head">Waste Head</option>
                                            <option value="Crime Head">Crime Head</option>
                                            <option value="Infrastructure Head">Infrastructure Head</option>
                                        </select>
                                    </div>
                                    <h5 class="fs-6" name="urole" id="urole<?=$row['ID']?>">Position: <?=' '.$row['UROLE']?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm me-2" value="<?=$row['ID']?>" name="cancel" id="cancel<?=$row['ID']?>" style="display:none;"><i class="bi bi-x"></i> Cancel</button>
                            <button type="button" class="btn btn-sm me-2" value="<?=$row['ID']?>" name="delete" id="delete<?=$row['ID']?>" data-bs-toggle="modal" data-bs-target="#confirmation"><i class="bi bi-trash"></i> Delete</button>
                            <button type="button" class="btn btn-sm me-2" value="<?=$row['ID']?>" name="edit"  id="edit<?=$row['ID']?>"><i class="bi bi-pen"></i> Edit</button>
                            <button type="button" class="btn btn-sm" value="<?=$row['ID']?>" name="save" id="save<?=$row['ID']?>" data-bs-toggle="modal" data-bs-target="#update" style="display: none;"><i class="bi bi-check"></i> Save</button>
                        </div>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        </div>
    </div>
    
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="confirmation" aria-hidde="true" aria-label="Confirmation">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this Account ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal"><i class="bi bi-x"></i> Cancel</button>
                    <button type="button" class="btn btn-sm" id="deleteID"><i class="bi bi-check"></i> Yes</button>
                </div>
            </div>
        </div>
    </div>
    
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" id="update" aria-hidde="true" aria-label="Update Account">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to chanage this Account Position?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal"><i class="bi bi-x"></i> Cancel</button>
                    <button type="button" class="btn btn-sm" id="updateID"><i class="bi bi-check"></i> Yes</button>
                </div>
            </div>
        </div>
    </div>
    

    <div class="toast-container">
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Micra Administrator</strong>
                    <small id="timeNow"></small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    New Admin account has been added !
                </div>
            </div>
        </div>
    </div>
    
    <?php 
        require '../process/accessDenied.php';
        
        $denied = new AccessDenied();
        $denied->isDeny($_SESSION['position']);
    ?>
<script>
    var save = $('button[name="save"]')
    var edit = $('button[name="edit"]')
    var cancel = $('button[name="cancel"]')
    var remove = $('button[name="delete"]')
    
    save.hide()
    cancel.hide()
    
    

    $(document).ready(function(){
        $('#addAdmin').submit(function(event){
            event.preventDefault();

            var send = $.post('../process/addAdmin.php',{
                username: $('#username').val(),
                password: $('#password').val(),
                email: $('#email').val(),
                firstname: $('#firstname').val(),
                lastname: $('#lastname').val(),
                position: $('#position').val(),
                contact: $('#contact').val()
            })

            send.done(function(data){
                $("#addAdmin").trigger('reset')

                switch(data){
                    case 'username':
                        $('#usernameerror').append('<small class="minimum text-danger">*Username is already used</small>')
                    case 'contact':
                        $('#contacterror').append('<small class="minimum text-danger">*Contact Number is already used</small>')
                    case 'email':
                        $('#emailerror').append('<small class="minimum text-danger">*Email is already used</small>')
                        break
                    default:
                        var successToast = $('#successToast')
                        var toast = new bootstrap.Toast(successToast)
                        document.getElementById('timeNow').innerHTML = formatAMPM(new Date())
                        toast.show()

                    }
                
               $( "#allAccounts" ).load(window.location.href + " #allAccounts" )
               
                setTimeout(function(){
                    location.reload()
                },2000)   
                
            })
        })
        
        edit.on('click',function(){
            var getVal = $(this).val()
            
            $('#delete'+getVal).hide()
            $('#save'+getVal).show()
            $('#cancel'+getVal).show()
            $('#edit'+getVal).hide()
            
            console.log(getVal)
            
            $('#editPosition'+getVal).show()
            $('#urole'+getVal).hide()
            
            
        })
        
        cancel.click(function(){
            var getVal = $(this).val()
            
            $('#delete'+getVal).show()
            $('#edit'+getVal).show()
            $('#save'+getVal).hide()
            $('#cancel'+getVal).hide()
            
            $('#editPosition'+getVal).hide()
            $('#urole'+getVal).show()
        })
        
        remove.click(function(){
            var getVal = $(this).val()
            $('#deleteID').click(function(){
                $.ajax({
                    url: '../process/deleteAdminAccount.php',
                    method: 'POST',
                    data: {id:getVal},
                    success: function(data){
                        $('#confirmation').modal('hide')
                        
                        var message = data
                        swal({
                            title: message,
                            icon: 'success',
                            button: 'Okay'
                        })
                        
                        $( "#allAccounts" ).load(window.location.href + " #allAccounts" )
                        
                        setTimeout(function(){
                            location.reload()
                        },2000)                        

                    }
                })
            })
        })
        
        save.click(function(){
            var getVal = $(this).val()
            var position = $('#select'+getVal).val()
            $('#updateID').click(function(){
                $.ajax({
                    url: '../process/updateAdmin.php',
                    method: 'POST',
                    data: {
                        id:getVal,
                        position:position
                    },
                    success: function(data){
                        $('#update').modal('hide')
                        var message = data
                        swal({
                            title: message,
                            icon: 'success',
                            button: 'Okay'
                        })
                        
                        $( "#allAccounts" ).load(window.location.href + " #allAccounts" )
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }
                })
            })
        })
        

        function formatAMPM(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }
        
    })
</script>
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>