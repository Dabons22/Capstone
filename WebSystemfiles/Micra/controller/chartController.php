<?php 

    include '../model/chartModel.php';

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    class ChartController{

        private $chartModel;

        public function __construct(){
            $this->chartModel = new ChartModel();
        }

        public function Data(){

            $data = array(
                'TotalReports'=>$this->totalReport(),
                'TotalFinished'=>$this->totalFinished(),
                'TotalOngoing'=>$this->totalOngoing(),
               
            );

            return $data;
            
        }

        public function totalReport(){
            
            $data = array(
                'Crime'=>$this->totalIncident(),
                'Infrastructure'=>$this->totalInfra(),
                'Waste'=>$this->totalWaste()
                
            );

            return $data;
        }

        public function totalOngoing(){
            $chartModel = $this->chartModel;
            
            $incident = $chartModel->numberOfIncident('On-going');
            $infra = $chartModel->numberOfInfrastructure('On-going');
            $waste = $chartModel->numberOfWaste('On-going');

            $data =array(
                'Incident'=> $incident, 
                'Infrastructure'=>$infra,
                'Waste'=>$waste
            );

            return $data;
        }

        public function totalFinished(){
            $chartModel = $this->chartModel;
            
            $incident = $chartModel->numberOfIncident('Finished');
            $infra = $chartModel->numberOfInfrastructure('Finished');
            $waste = $chartModel->numberOfWaste('Finished');

            $data = array(
                'Incident'=>$incident,
                'Infrastructure'=>$infra,
                'Waste'=>$waste
            );

            return $data;
        }

        public function totalIncident(){
            $chartModel = $this->chartModel;
            $pending = $chartModel->numberOfIncident('Pending');
            $ongoing = $chartModel->numberOfIncident('On-going');
            $finished = $chartModel->numberOfIncident('Finished');

            $totalIncident = $pending + $ongoing + $finished;

            return $totalIncident;
        }

        public function totalWaste(){
            $chartModel = $this->chartModel;

            $pending = $chartModel->numberOfWaste('Pending');
            $ongoing = $chartModel->numberOfWaste('On-going');
            $finished = $chartModel->numberOfWaste('Finished');

            $totalWaste = $pending + $ongoing + $finished;

            return $totalWaste;
        }

        public function totalInfra(){
            $chartModel = $this->chartModel;

            $pending = $chartModel->numberOfInfrastructure('Pending');
            $ongoing = $chartModel->numberOfInfrastructure('On-going');
            $finished = $chartModel->numberOfInfrastructure('Finished');

            $totalInfra = $pending + $ongoing + $finished;

            return $totalInfra;
        }

        public function totalRegistred(){
            $chartModel = $this->chartModel;

            $data = array(
                'verified'=>$chartModel->numberOfRegistered('Yes'),
                'notVerified'=>$chartModel->numberOfRegistered('No')
            );

            return $data;
        }
                public function savedNotes(){
            
            $data = array(
                'textarea_content'=>$this->content()
            );

            return $data;
        }
        
        //Fetch Data from of the Pending and Finished Report
        
        public function getPending(){
            $chartModel = $this->chartModel;

            $data = array(
                'incident'=>$chartModel->incidentReport('Pending'),
                'infrastructure'=>$chartModel->infraReport('Pending'),
                'waste'=>$chartModel->wasteReport('Pending')
            );

            return $data;
        }
        
        public function getFinished(){
            $chartModel = $this->chartModel;

            $data = array(
                'incident'=>$chartModel->incidentReport('Finished'),
                'infrastructure'=>$chartModel->infraReport('Finished'),
                'waste'=>$chartModel->wasteReport('Finished')
            );

            return $data;
        }
        
        
        
        
        public function showNarrative(){
            $chartModel = $this->chartModel;
            
            $data = $chartModel->getNarrativeData();
            
            return $data;
        }
         public function showNarrative2(){
            $chartModel = $this->chartModel;
            
            $data = $chartModel->getNarrativeData2();
            
            return $data;
        }
         public function showNarrative3(){
            $chartModel = $this->chartModel;
            
            $data = $chartModel->getNarrativeData3();
            
            return $data;
        }
        
        public function printNarrative($id){
            $chartModel = $this->chartModel;
            
            $data = $chartModel->selectNarrative($id);
            
            return $data;
        }
        
        
        //I really don't know
        
        public function addAccount($data){
            $chartModel = $this->chartModel;

            $cleanData = array(
                'text'=>$this->clean($data['text'])
            );

            $chartModel->insertData($cleanData);
        }
/*        public function getCategoryData(){
            $chartModel = $this->chartModel;
            $data = array(
                'Incident'=>$chartModel->getByCategory('Incident'),
                'Infrastructure'=>$chartModel->getByCategory('Infastructure'),
                'Waste'=>$chartModel->getByCategory('Waste')
            );

            return $data;
        }

        public function getSortedData(){
            $chartModel = $this->chartModel;

            $data = $chartModel->getData();
            usort($data,array($this,"sortArray"));
            $month = array();
            $day = array();
            $filtered = array();
            foreach($data as $filteredData){
                $month[] = date('F',strtotime($filteredData));
                $day[] = date('F d',strtotime($filteredData));
            }
            $month = array_count_values($month);
            $day = array_count_values($day);

            $filtered = array(
                'Month'=>$month,
                'Day'=>$day
            );
            return $filtered;
        }

        //Convert the Date from String to Date
        public function sortArray($array,$sort){
            return strtotime($array) - strtotime($sort);
        }

        //Function that return Table Data
        public function getTableData(){
            $chartModel = $this->chartModel;

            $data = $chartModel->getTable();

            return $data;
        }
        */
    }