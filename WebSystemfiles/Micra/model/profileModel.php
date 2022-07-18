<?php

    require '../config.php';
    
    class ProfileModel extends Database{
        public function connect(){
            $connection = new mysqli($this->servername,$this->username,$this->password,$this->database);
            
            if(!$connection->connect_error){
                return $connection;
            }
        }
        
        public function fetchProfileData($id){
            $connection = $this->connect();
            
            $stmt = $connection->prepare('SELECT * FROM tbluseraccounts WHERE ID=?');
            $stmt->bind_param('i',$id);
            $stmt->execute();
            
            $stmt->bind_result($id,$fullname,$username,$password,$position,$image,$contact,$email);
            
            while($stmt->fetch()){
                $result = array(
                        'id'=>$id,
                        'fullname'=>$fullname,
                        'username'=>$username,
                        'password'=>$password,
                        'position'=>$position,
                        'image'=>$image,
                        'contact'=>$contact,
                        'email'=>$email
                    );
            }
            
            return $result;
        }
        
        public function updateProfilePic($id,$image){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("UPDATE tbluseraccounts SET USERPHOTO=? WHERE ID=?");
            $stmt->bind_param('si',$image,$id);
            $stmt->execute();
        }
        
    }