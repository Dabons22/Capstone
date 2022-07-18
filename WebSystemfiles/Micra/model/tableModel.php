<?php 

    require '../config.php';

    class TableModel extends Database{

        public function __constuct(){
            
            return $this->connect();
        }

        public function connect(){
            $connection = new mysqli($this->servername,$this->username,$this->password,$this->database);
            
            if(!$connection->connect_error){
                return $connection;
            }
        }

        //SELECT

        public function incidentReport(string $status){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tblincident WHERE resolvestatus=? ORDER BY reportdate DESC");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $result = $stmt->get_result();
            
            return $result;
        }

        public function wasteReport(string $status){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM tblwaste WHERE status=? ORDER BY dateReported DESC" );
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result;
        }

        public function infraReport(string $status){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM tblinfra WHERE resolvestatus=? ORDER BY reportdate DESC");
            $stmt->bind_param('s',$status);
            $stmt->execute();

            $result = $stmt->get_result();

            return $result;
        }


        //Functions for Updating Report status from Pending to Ongoing

        public function updateIncident($id,$status,$message,$responder,$respondDate,$respondTime){
            $connection = $this->connect();

            $stmt = $connection->prepare("UPDATE tblincident SET resolvestatus=?, repondate=?, respondtime=?, respondername=?, respondmessage=? WHERE reportnumber=?");
            $stmt->bind_param("sssssi",$status,$respondDate,$respondTime,$responder,$message,$id);
            $stmt->execute();

        }

        public function updateInfra($id,$status,$message,$responder,$respondDate,$respondTime){
            $connection = $this->connect();

            $stmt = $connection->prepare("UPDATE tblinfra SET resolvestatus=?, repondate=?, respondtime=?, respondername=?, respondmessage=? WHERE reportnumber=?");
            $stmt->bind_param("sssssi",$status,$respondDate,$respondTime,$responder,$message,$id);
            $stmt->execute();

        }

        public function updateWaste($id,$status,$message,$responde,$respondDate,$respondTime){
            $connection = $this->connect();

            $stmt = $connection->prepare("UPDATE tblwaste SET status=?, repondate=?, respondtime=?, respondername=?, respondmessage=? WHERE reportnumber=?");
            $stmt->bind_param("sssssi",$status,$respondDate,$respondTime,$responder,$message,$id);
            $stmt->execute();

        }

        //Functions for Updating Report Status from Ongoing to finished and send a Feedback to the Reporter

        public function finishedIncident($id,$message,$date,$time,string $status){
            $connection = $this->connect();

            $stmt = $connection->prepare("UPDATE tblincident SET resolvetime=? , resolvedate=? , resolvefeedback=? , resolvestatus=? WHERE reportnumber=?");
            $stmt->bind_param('ssssi',$time,$date,$message,$status,$id);
            $stmt->execute();
        }

        public function finishedInfra($id,$message,$date,$time,string $status){
            $connection = $this->connect();

            $stmt = $connection->prepare("UPDATE tblinfra SET resolvetime=? , resolvedate=? , resolvefeedback=? , resolvestatus=? WHERE reportnumber=?");
            $stmt->bind_param('ssssi',$time,$date,$message,$status,$id);
            $stmt->execute();
        }

        public function finishedWaste($id,$message,$date,$time,string $status){
            $connection = $this->connect();

            $stmt = $connection->prepare("UPDATE tblwaste SET feedback=? , status=? , resolvedate=? , resolvetime=? WHERE reportnumber=?");
            $stmt->bind_param('ssssi',$message,$status,$date,$time,$id);
            $stmt->execute();
        }
        
        //Get user Email and Contact Number
        
        public function getUserContact($id){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT number FROM tbregister WHERE id=?");
            $stmt->bind_param('i',$id);
            $stmt->execute();
            
            $stmt->bind_result($contact);
            $result = "";
            while($stmt->fetch()){
                $result = $contact;
            }
            
            return $result;
        }
        
                
        public function getUserEmail($id){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT email FROM tbregister WHERE id=?");
            $stmt->bind_param('i',$id);
            $stmt->execute();
            
            $stmt->bind_result($email);
            $result = "";
            while($stmt->fetch()){
                $result = $email;
            }
            
            return $result;
        }
        
        public function searchIncident($search){
            $connection = $this->connect();
            
            $where = "reportername LIKE '.$search.' OR reportlocation LIKE '.$search.' OR categorydescription LIKE '.$search.' OR reportdescription LIKE '.$search";
            $stmt = $connection->prepare("SELECT * FROM tblincident WHERE reportername LIKE '%Crime%' OR reportlocation LIKE '%Crime%' OR categorydescription LIKE '%Crime' OR reportdescription LIKE '%Crime%' OR reportcategory LIKE '%Crime%' AND resolvestatus='Pending'");
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }

    }