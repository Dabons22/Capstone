<?php 

    require '../model/savedModel.php';

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

        public function updateIncidentStatus(string $status, $id){
            $tableModel = $this->tableModel;

            $tableModel->updateIncident($id,$status);
        }

        public function updateInfraStatus(string $status, $id){
            $tableModel = $this->tableModel;

            $tableModel->updateInfra($id,$status);
        }

        public function updateWasteStatus(string $status, $id){
            $tableModel = $this->tableModel;

            $tableModel->updateWaste($id,$status);
        }

        //Finish Controller

        public function updateFinishedIncident($data){
            $tableModel = $this->tableModel;

            $tableModel->finishedIncident($data['id'],$data['message'],$data['date'],'Finished');
        }

        public function updateFinishedInfra($data){
            $tableModel = $this->tableModel;

            $tableModel->finishedInfra($data['id'],$data['message'],$data['date'],'Finished');
        }

        public function updateFinishedWaste($data){
            $tableModel = $this->tableModel;

            $tableModel->finishedWaste($data['id'],$data['message'],'Finished');
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