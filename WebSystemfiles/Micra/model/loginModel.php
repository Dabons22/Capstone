<?php

    require '../config.php';


    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    class LoginModel extends Database{

        public function connect(){
            $connection = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if(!$connection->connect_error){
                return $connection;
            }
        }

        public function processLogin($username,$password){
            $connection  = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM tbluseraccounts WHERE USERNAME=?");
            $stmt->bind_param("s",$username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = array();
            
            if($result->num_rows == 1){
                while($row = $result->fetch_assoc()){
                    $getPassword = $row['PASS'];
                    if(!password_verify($password,$getPassword)){
                        
                        return false;

                    }else{

                        $data['id'] = $row['ID'];
                        $data['username'] = $row['USERNAME'];
                        $data['position'] = $row['UROLE'];
                        $data['fullname'] = $row['FULLNAME'];
                        $data['emails'] = $row['EMAIL'];
                        $data['contact'] = $row['CONTACT'];
                    }
                }

                return $data;
                
            }else{

                return false;
            }
        }
        
         //OTP for Email

        public function email($email){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT EMAIL FROM tbluseraccounts WHERE EMAIL=?");
            $stmt->bind_param('s',$email);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;
        }

        //OTP for Phone Number

        public function contact($number){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT CONTACT FROM tbluseraccounts WHERE CONTACT=?");
            $stmt->bind_param('s',$number);
            $stmt->execute();

            $stmt->store_result();
            $result = $stmt->num_rows;

            return $result;
        }
        
        //Update Password
        public function updateByEmail($pass,$email){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("UPDATE tbluseraccounts SET PASS=? WHERE EMAIL=?");
            $stmt->bind_param('ss',$pass,$email);
            $stmt->execute();
        }
        
        public function updateByContact($pass,$contact){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("UPDATE tbluseraccounts SET PASS=? WHERE CONTACT=?");
            $stmt->bind_param('ss',$pass,$contact);
            $stmt->execute();
        }
        
        //Insert Log
        
        public function insertLogin($username,$date,$login){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("INSERT INTO tbllogs(username,date,login) VALUES(?,?,?)");
            $stmt->bind_param('sss',$username,$date,$login);
            $stmt->execute();
        }
        
        public function insertLogout($username,$date,$login,$logout){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("UPDATE tbllogs SET logout=? WHERE username=? AND date=? AND login=?");
            $stmt->bind_param('ssss',$logout,$username,$date,$login);
            $stmt->execute();
        }
        
        //Fetch Login and Logout History
        
        public function selectLogs(){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tbllogs");
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }
        
        
        //fetch print
        public function selectprint($id){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT textarea_content FROM saved_notes WHERE id=?");
            $stmt->bind_param('i',$id);
            $stmt->execute();
            
            $stmt->bind_result($filename);
            $result='';
            
            while($stmt->fetch()){
                $result = $filename;
            }
            
            return $result;
        }
        
        //Remove only One Login and Logout History
        
        public function removeOneLog($data){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("DELETE FROM tbllogs WHERE id=?");
            $stmt->bind_param('i',$data);
            $stmt->execute();
            
        }
        
        //Clear all Login and Logout History
        
        public function removeLogData(){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("TRUNCATE TABLE tbllogs");
            $stmt->execute();
        }
        
    }