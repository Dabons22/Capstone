<?php

    require '../model/analyticsModel.php';
    
    class AnalyticsController{
        
        private $analyticsModel;
        
        public function __construct(){
            $this->analyticsModel = new AnalyticsModel();
        }
        
        public function Analytics(){
            
            $totalReport = $this->reportTotal();
            $data = array(
                'total'=>$totalReport,
                
                );
            
            return $data;
        }
        
        public function reportTotal(){
            $analyticsModel = $this->analyticsModel;
            
            $incident = $analyticsModel->incidentData();
            $waste = $analyticsModel->wasteData();
            $infra = $analyticsModel->infraData();
            
            usort($incident,array($this,'sortData'));
            usort($waste,array($this,'sortData'));
            usort($infra,array($this,'sortData'));
            
            $data = array(
                'incident'=>array_count_values($incident),
                'waste'=>array_count_values($waste),
                'infra'=>array_count_values($infra)
                );
            
            return $data;
        }
        
        
        
        
        //Sorting Date
        public function sortData($array,$sort){
            return strtotime($array) - strtotime($sort);
        }
    }
    