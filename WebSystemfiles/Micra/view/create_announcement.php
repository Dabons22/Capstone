<?php 
    session_start();
    require '../controller/announcementController.php';

    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }

    $controller = new AnnouncementController();

    //After Posting the announcement dapat ma redirect sya sa Manage Announcement page
    if(isset($_POST['submit'])){
        $subject = $_POST['subject'];
        $content = $_POST['content'];
        $username = $_SESSION['username'];
        $controller->moveimage($_FILES['image']['name'],$_FILES['image']['tmp_name']);
        $date = date('Y-m-d');
        $controller->addAnnouncement($subject,$content,$_FILES['image']['name'],$username,$date);
        header('Location: ../view/manage_announcement.php');
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
    <div class="container-sm mt-5 p-5 shadow">
        <div class="container-sm">
            <h3 class="fs-4 fw-bold">Create New Announcement</h3>
        </div>
        <hr class="mb-4">
        <div class="container-sm border p-3">
            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                <div class="text-center">
                    <span>
                        <img class="mb-3" id="selectedImage">
                    </span>
                </div>
                <div class="form-floating mb-3 col-sm-6">
                    <input class="form-control" type="text" id="subject" name="subject" placeholder="Subject" required>
                    <label for="subject">Subject</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Content" name="content" id="content" required></textarea>
                    <label for="content">Content</label>
                </div>
                <div class="mb-3">
                    <input type="file" class="form-control" id="image" name="image" accept=".jpeg,.png,.jpg">
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn" type="submit" role="submit" name="submit" value="submit"><i class="bi bi-file-plus"></i> Post</button>
                </div>
            </form>
        </div>
    </div>


<script>
    $(document).ready(function(){
        $('#content').each(function(){
        this.setAttribute('style','height:' +(this.scrollHeight) +'px;overflow-y:hidden')
        }).on('input',function(){
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        })

        function readUrl(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();

                reader.onload = function(e){
                    $('#selectedImage').attr('src',e.target.result)
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#image').change(function(){
            readUrl(this)
        })
    })
</script>
<!----------- Footer ----------->   
<?php include '../resources/footer/footer.php' ?>