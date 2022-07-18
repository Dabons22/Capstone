<?php 
    
    class AccessDenied{
        public function isDeny($position){
            
            $denied =  '<div class="modal fade" id="accessDenied" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="accessDeniedLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="accessDeniedLabel">Access Denied</h5>
                    </div>
                    <div class="modal-body">
                        <p class="fs-6">You dont have an access to this Page. Please contact the Main Administrator for more Inquiries.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="goBack">Go Back</button>
                    </div>
                </div>
            </div>
        </div><script>
        $(document).ready(function(){
            $("#accessDenied").modal("show")
            
            $("#goBack").click(function(){
                history.back()
            })
        
            setInterval(function(){
                history.back()
            },3000)
        })
        </script>';

            if($position != 'Main Administrator'){
                echo $denied;
            }
        }
    }

?>