   <?php
    require '../controller/profileController.php';

    session_start();
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }

    $controller = new ProfileController();
    
    $data = $controller->getAccountData($_SESSION['id']);

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

<body>
<style>

	.gradient-custom {

  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background: linear-gradient(to right bottom,rgb(225, 0, 1), rgba(253, 160, 133, 1))
}

</style>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <?php 
                            $image = $data['image'];
                            $directory = '../resources/files/user/'.$image;
                            
                            if(!file_exists($directory) || empty($data['image'])){
                                $directory = '../resources/files/user.png';
                            }
                        
                        ?>
                        <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                            <img src="<?=$directory?>" alt="Avatar" id="croppedImage" class="img-fluid my-5" style="width: 75%; border-radius: 50%;">
                            <div class="text-center mb-2">
                                <label class="btn btn-sm">
                                    Change Profile
                                    <input type="file" class="form-control" accept=".jpeg,.jpg,.png" name="image" id="profilePic" hidden>
                                </label>
                            </div>
                            <h5><?=$data['fullname'] ?></h5>
                            <p><?=$data['position']?></p>
                            <i class="far fa-edit mb-5"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6>Information</h6>
                                <hr class="mt-0 mb-4">
                        
                                <div class="row pt-1">
                                    <div class="col mb-3">
                                        <h6>Username</h6>
                                        <p class="text-muted"><?=$data['username']?></p>
                                    </div>
                                </div>
                        
                                <div class="row">
                                    <div class="col mb-3">
                                        <h6>Email</h6>
                                        <p class="text-muted"><?=$data['email']?></p>
                                    </div>
                                </div>
                          
                                <div class="row">
                                    <div class="col mb-3">
                                        <h6>Contact Number</h6>
                                        <p class="text-muted"><?=$data['contact']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" data-bs-backdrop="static" id="imageModal">
            <div class="modal-dialog modal-dialog-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image</h5>
                        <button type="button" id="close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex g-5">
                            <div class="image-container text-center mb-4">
                                <img id="image" alt="Profile Picture">
                            </div>
                            <div class="col text-center">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="crop" class="btn">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script>
    $(document).ready(function(){
        var myModal = $('#imageModal')[0]
        var newModal = new bootstrap.Modal(myModal)
        var image = $('#image')[0]
        
        $('#profilePic').change(function(){
            readUrl(this)
            newModal.show()
        })
        
        $('#close').on('click',function(){
            $('#profilePic').val('')
        })
        
        $('#imageModal').on('shown.bs.modal',function(){
            cropper = new Cropper(image,{
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            })
        }).on('hide.bs.modal',function(){
            cropper.destroy()
            cropper = null
        })
        
        $('#crop').click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 100
            })
            
            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob)
                var reader = new FileReader()
                
                reader.readAsDataURL(blob)
                reader.onloadend = function(){
                    var base64Data = reader.result
                    $.ajax({
                        url: '../process/saveImage.php',
                        method: 'POST',
                        data: {image: base64Data},
                        success: function(data){
                            newModal.hide()
                            $('#croppedImage').attr('src',data)
                        }
                    })
                }
            })
        })
        
        function readUrl(input){
            if(input.files && input.files[0]){
                var reader = new FileReader()
                
                reader.onload = function(e){
                    $('#image').attr('src',e.target.result)
                }
                
                reader.readAsDataURL(input.files[0])
            }
        }
    })
    
    
    
</script>
<!----------- Footer ----------->    
<?php include '../resources/footer/footer.php' ?>