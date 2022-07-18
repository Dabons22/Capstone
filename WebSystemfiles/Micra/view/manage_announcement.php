<?php 
    session_start();
    require '../controller/announcementController.php';
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }

    $controller = new AnnouncementController();

    $data = $controller->getAnnouncement();

    
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
    <div class="container mt-5 p-5 shadow">
        <div class="container-sm">
            <h3 class="fs-4 fw-bold text-center">Barangay Announcements</h3>
        </div>
        <hr class="mb-4">
        <div id="allAnnouncements">
            <?php while($row = $data->fetch_assoc()){ ?>
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Announcement Header -->
                    <div class="d-flex mb-5">
                        <div class="hstack gap-3">
                          <small class="text-muted ms-3">Posted By :<?=' '.$row['postedBy']; ?></small>
                          <div class="vr"></div>
                          <small class="text-muted"><?= date('F d, Y',strtotime($row['date'])) ?></small>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="fs-5 text-dark me-3" href="#" role="button" id="optionMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="optionMenu">
                                <li><button type="button" class="dropdown-item" name="delete" value="<?= $row['id'] ?>">Delete</button></li>
                                <li>
                                    <button type="button" class="dropdown-item" name="edit" id="edit<?=$row['id']?>" data-bs-toggle="modal" data-bs-target="#announcement<?=$row['id']?>">Edit
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!--Announcement Edit Moda-->
                    <form>
                        <div class="modal fade" data-bs-backdrop="static" tabindex="-1" id="announcement<?=$row['id']?>" aria-hidden="true" aria-label="Edit Announcement">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Announcement</h5>
                                        <button type="reset" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="editContent" rows="8" placeholder="New Content" name="editContent" required>
                                                <?=$row['description']?>
                                            </textarea>
                                            <label for="editContent">Content</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    
                    
                    <!--Announcement Main Content--> 
                    <div class="container">
                        <div class="row mb-3">
                            <div class="card-title">
                                <strong class="fs-5"><?=$row['title']?></strong>
                            </div>
                        </div>
    
                        <div class="row mb-3">
                            <div class="text-center">
                                <span>
                                    <img class="mb-3" id="selectedImage" <?php if(!empty($row['image'])){ echo "src=../resources/files/announcement/".$row['image'].""; }  ?>>
                                </span>
                            </div>
                            <p class="fs-6"><?= $row['description']?></p>
                        </div>
                    </div>  
    
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
<script>
    $(document).ready(function(){
        $('#editContent').each(function(){
            this.setAttribute('style','height:' +(this.scrollHeight) +'px;overflow-y:hidden')
        }).on('input',function(){
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            })
        
        
        $('button[name="delete"]').on('click',function(){
            var id = $(this).val()
            var del = $.get('../process/deleteAnnouncement.php',{ id:id })
            
            del.done(function(data){
                $( "#allAnnouncements" ).load(window.location.href + " #allAnnouncements" )
            })
        })
    })
</script>
<!----------- Footer ----------->   
<?php include '../resources/footer/footer.php' ?>