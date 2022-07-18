<?php 

    require '../config.php';
    
    class UserModel extends Database{
        
        public function connect(){
            $connection = new mysqli($this->servername,$this->username,$this->password,$this->database);
            
            if(!$connection->connect_error){
                return $connection;
            }
        }
        
        public function userRegistration(string $verified){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tbregister WHERE isVerified=?");
            $stmt->bind_param('s',$verified);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }
         public function yesVerified(string $verified){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT * FROM tbregister WHERE isVerified=?");
            $stmt->bind_param('s',$verified);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }
        
        
        public function setVerified($id,string $isVerified){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("UPDATE tbregister SET isVerified=? WHERE id=?");
            $stmt->bind_param("si",$isVerified,$id);
            $stmt->execute();
        }
        
          //Remove only One Login and Logout History
        
        public function deleteAccount($data){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("DELETE FROM tbregister WHERE id=?");
            $stmt->bind_param('i',$data);
            $stmt->execute();
            
        }
    }