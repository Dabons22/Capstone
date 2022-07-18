<?php

    require '../config.php';

    class ChartModel extends Database{

        public function connect(){
            $connection = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if(!$connection->connect_error){
                return $connection;
            }
        }
        
        public function numberOfIncident(string $status){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tblincident WHERE Finished");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;

        }

        public function numberOfWaste(string $status){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tblwaste WHERE status=Finished");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;

        }

        public function numberOfInfrastructure(string $status){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tblinfra WHERE resolvestatus=Finished");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;

        }

        public function numberOfRegistered(string $verified){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM saved_notes");
            $stmt->bind_param("s",$verified);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;
        }
    }