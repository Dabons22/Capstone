<?php 

    require '../controller/loginController.php';

    session_start();
    if(!isset($_SESSION['username']) and !isset($_SESSION['id'])){
        header('Location: login.php');
    }

    $controller = new LoginController();
    $data = $controller->showLogs();

?>

<!----------- Header ----------->
<?php include '../resources/header/header.php' ?>
<?php include '../resources/header/navigation.php' ?>

<body>
    
	<div class="container mb-5 p-5 shadow">
	    <h4 class="fs-5 fw-bold">Log History</h4>
            <div id="datas">
        		<table class="table table-striped table-bordered text-center display compact" id="logs" style="width: 100%">
        			<thead>
        				<th scope="col"> ID </th>
        		        <th scope="col"> Username </th>
        		        <th scope="col"> Date </th>
        		        <th scope="col"> Login </th>
        		        <th scope="col"> Logout </th>
        		        <th></th>
        			</thead>
        
        			<tbody>
        			    <?php while($row = $data->fetch_assoc()){ ?>
                        <tr>
        		          <th scope="row"><?=$row['id']?></th>
        		          <td><?=$row['username']?></td>
        		          <td><?=$row['date']?></td>
        		          <td><?=$row['login']?></td>
        		          <td><?=$row['logout']?></td>
        		          <td> <button type="button" class="btn btn-sm" name="remove" value="<?=$row['id']?>"><i class="bi bi-trash"> Delete </i></button> </td>
        		        </tr>
        		        <?php } ?>
        			</tbody>
        		</table>
        	</div>
		
		<div class="d-flex mt-3">
		    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#clearLogModal"><i class="bi bi-trash"></i> Clear Log History</button>
		    
		    <div class="modal fade" id="clearLogModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="clearLogLabel" aria-hidden="true">
		        <div class="modal-dialog modal-dialog-center">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <h5  class="modal-title " id="clearLogLabel">
		                        <i class="bi bi-question-circle"></i> Confirmation 
		                    </h5>
		                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
		                </div>
		                <div class="modal-body">
		                    <h5 class="fs-6"> Are you sure you want to remove all Log Data ? </h5>
		                </div>
    		            <div class="modal-footer">
    		                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
    		                <button type="submit" class="btn" id="clearLogs" name="clearLogs" value="Clear">Confirm</button>
    		            </div>
		            </div>    
		        </div>
		    </div>
		</div>
	</div>
		
<script>
    $(document).ready(function(){
        $('#logs').DataTable()
        
        //Clear Log
        
        $('#clearLogs').click(function(){
            var clear = $.ajax({
                url: '../process/clearLog.php'
            })
            
            clear.done(function(data){
                console.log(data)
                location.reload()
            })
        })
        
        //Remove Single Log
        
        $('button[name="remove"]').on('click',function(){
            var id = $(this).val();
            console.log(id)
            var remove = $.ajax({
                type: "GET",
                url: '../process/removeLog.php',
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
<!----------- Footer ----------->
<?php include '../resources/footer/footer.php'; ?>