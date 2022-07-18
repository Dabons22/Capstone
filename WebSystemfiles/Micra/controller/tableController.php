<?php 

    require '../model/tableModel.php';

    class TableController{

        private $tableModel;
        protected $category;
        protected $status;


        public function __construct(){
            $this->tableModel = new TableModel();
        }

        public function getPending(){
            $tableModel = $this->tableModel;

            $data = array(
                'incident'=>$tableModel->incidentReport('Pending'),
                'infrastructure'=>$tableModel->infraReport('Pending'),
                'waste'=>$tableModel->wasteReport('Pending')
            );

            return $data;
        }

        public function getOngoing(){
            $tableModel = $this->tableModel;

            $data = array(
                'incident'=>$tableModel->incidentReport('On-going'),
                'infrastructure'=>$tableModel->infraReport('On-going'),
                'waste'=>$tableModel->wasteReport('On-going')
            );

            return $data;
        }

        public function getFinished(){
            $tableModel = $this->tableModel;

            $data = array(
                'incident'=>$tableModel->incidentReport('Finished'),
                'infrastructure'=>$tableModel->infraReport('Finished'),
                'waste'=>$tableModel->wasteReport('Finished')
            );

            return $data;
        }

        //Update Controller

        public function updateIncidentStatus(string $status, $id,$message,$responder,$respondDate,$respondTime){
            $tableModel = $this->tableModel;
            
            $tableModel->updateIncident($id,$status,$message,$responder,$respondDate,$respondTime);
        }

        public function updateInfraStatus(string $status, $id,$message,$responder,$respondDate,$respondTime){
            $tableModel = $this->tableModel;

            $tableModel->updateInfra($id,$status,$message,$responder,$respondDate,$respondTime);
        }

        public function updateWasteStatus(string $status, $id,$message,$responder,$respondDate,$respondTime){
            $tableModel = $this->tableModel;

            $tableModel->updateWaste($id,$status,$message,$responder,$respondDate,$respondTime);
        }

        //Finish Controller

        public function updateFinishedIncident($data){
            $tableModel = $this->tableModel;

            $tableModel->finishedIncident($data['id'],$data['message'],$data['date'],$data['time'],'Finished');
        }

        public function updateFinishedInfra($data){
            $tableModel = $this->tableModel;

            $tableModel->finishedInfra($data['id'],$data['message'],$data['date'],$data['time'],'Finished');
        }

        public function updateFinishedWaste($data){
            $tableModel = $this->tableModel;

            $tableModel->finishedWaste($data['id'],$data['message'],$data['date'],$data['time'],'Finished');
        }

        //Get User Contact and Email
        
        public function getContact($id){
            $tableModel = $this->tableModel;
            
            $contact = $tableModel->getUserContact($id);
            
            return $contact;
        }
        
        public function getEmail($id){
            $tableModel = $this->tableModel;
            
            $email = $tableModel->getUserEmail($id);
            
            return $email;
        }
        
        //Search report
        
        public function search($search,$tablename){
            $tableModel = $this->tableModel;
            
            $data = $tableModel->searchIncident($search);
            
            $card ='';
            while($row = $data->fetch_assoc()){
                $image = '../../IncidentReport/'.$row['reportimg'];
                if(!file_exists($image) || empty($row['reportimg'])){
                    $image = '../resources/files/background.png';
                }
                $card .='<div class="card me-3 mb-5 border p-2">
                            <div class="text-center">
                                <img src="'.$image.'" alt="Report Image" class="card-img-top">
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li><p class="card-title" name="reportID"><label class="fw-bold">Report ID:</label>'.' '.$row['reportnumber'].'</p></li>
                                </ul>
                            </div>
                        </div>
                ';
            }
            
            return $card;
        }








    /*
        public function setCategory(string $category,string $status){
            $this->category = $category;
            $this->status = $status;
        }

        public function setStatus(string $status){
            $this->status = $status;
        }

        public function collectCategoryData(){
            $incidentModel = $this->incidentModel;
            $data = $incidentModel->getCategoryData($this->category,$this->status);

            return $data;

        }

        public function collectStatusData(){
            $incidentModel = $this->incidentModel;
            $data = $incidentModel->getStatusData($this->status);

            return $data;
        }

        public function updateFeedback($id,$message,$date){
            $incidentModel = $this->incidentModel;
            $status = 'Finished';
            $incidentModel->insertFeedback($id,$message,$status,$date);
        }

        public function updateReportStatus($id){
            $incidentModel = $this->incidentModel;
            $status = 'Ongoing';
            $incidentModel->updateStatus($id,$status);

        }
            */
    }