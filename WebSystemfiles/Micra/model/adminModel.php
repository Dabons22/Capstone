<?php

    require '../config.php';

    class AdminModel extends Database{

        public function connect(){
            $connection = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if(!$connection->connect_error){
                return $connection;
            }
        }

        public function checkUsername($username){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT USERNAME FROM tbluseraccounts WHERE USERNAME = ?");
            $stmt->bind_param('s',$username);
            $stmt->execute();

            $stmt->store_result();

            $result = $stmt->num_rows;

            return $result;

        }
        
        public function checkEmail($email){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT EMAIL FROM tbluseraccounts WHERE EMAIL=?");
            $stmt->bind_param('s',$email);
            $stmt->execute();
            
            $stmt->store_result();
            
            $result = $stmt->num_rows;
            
            return $result;
        
        }
        
        public function checkContact($contact){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("SELECT CONTACT FROM tbluseraccounts WHERE CONTACT=?");
            $stmt->bind_param('s',$contact);
            $stmt->execute();
            
            $stmt->store_result();
            
            $result = $stmt->num_rows;
            
            return $result;
        
        }


        public function insertData($data){
            $connection = $this->connect();

            $stmt = $connection->prepare("INSERT INTO tbluseraccounts(FULLNAME,USERNAME,PASS,UROLE,CONTACT,EMAIL) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param("ssssss",$data['fullname'],$data['username'],$data['password'],$data['position'],$data['contact'],$data['email']);
            $stmt->execute();

        }
        
        //Delete Admin Account
        
        public function deleteAccount($id){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("DELETE FROM tbluseraccounts WHERE ID=?");
            $stmt->bind_param('i',$id);
            $stmt->execute();
        }
        
        //Update Admin Account
        
        public function updateAccount($id,$position){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("UPDATE tbluseraccounts SET UROLE=? WHERE ID=?");
            $stmt->bind_param('si',$position,$id);
            $stmt->execute();
        }
        
        public function account(){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM tbluseraccounts");
            $stmt->execute();

            $result = $stmt->get_result();

            return $result;
            
        }
    }