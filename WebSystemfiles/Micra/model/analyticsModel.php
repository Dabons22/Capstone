<?php

    require '../config.php';
    
    class AnalyticsModel extends Database{
        public function connect(){
            
            $connection = new mysqli($this->servername,$this->username,$this->password,$this->database);
        
            if(!$connection->connect_error){
                return $connection;
            }
        }
        
        public function incidentData(){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT reportdate FROM tblincident");
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()){
                
                $data[] = date('F Y',strtotime($row['reportdate']));
            }
            
            return $data;
            
        }
        
        public function wasteData(){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT dateReported FROM tblwaste");
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()){
                
                $data[] = date('F Y',strtotime($row['dateReported']));
            }
            
            return $data;
        }
        
        public function infraData(){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT reportdate FROM tblinfra");
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()){
                
                $data[] = date('F Y',strtotime($row['reportdate']));
            }
            
            return $data;
            
        }
    }