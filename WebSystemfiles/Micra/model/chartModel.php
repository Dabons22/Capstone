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
            
            $stmt = $connection->prepare("SELECT * FROM tblincident WHERE resolvestatus=?");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;

        }

        public function numberOfWaste(string $status){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tblwaste WHERE status=?");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;

        }

        public function numberOfInfrastructure(string $status){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tblinfra WHERE resolvestatus=?");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;

        }

        public function numberOfRegistered(string $verified){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM tbregister WHERE isVerified=?");
            $stmt->bind_param("s",$verified);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;
        }
        
        public function incidentReport(string $status){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tblincident WHERE resolvestatus=? ORDER BY reportnumber DESC LIMIT 5");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $result = $stmt->get_result();
            
            return $result;
        }

        public function wasteReport(string $status){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM tblwaste WHERE status=? ORDER BY reportnumber DESC LIMIT 5");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result;
        }

        public function infraReport(string $status){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM tblinfra WHERE resolvestatus=? ORDER BY reportnumber DESC LIMIT 5");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result;
        }
        
        public function getNarrativeData(){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM saved_notes");
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }
        public function getNarrativeData2(){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM saved_notes");
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }
        public function getNarrativeData3(){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM saved_notes ");
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }
        
        public function selectNarrative($id){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM saved_notes WHERE id=?");
            $stmt->bind_param('i',$id);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }
        
        
        //I Don't Know
        
       public function insertData($data){
            $connection = $this->connect();

            $stmt = $connection->prepare("insert into save_notes(textarea_content) values (?)");
            $stmt->bind_param("ssssss",$data['text']);
            $stmt->execute();

        }
    
    }
    