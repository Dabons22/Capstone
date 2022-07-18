<?php 

    require '../config.php';

    class AnnouncementModel extends Database{
        
        public function connect(){
            $connection = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if(!$connection->connect_error){
                return $connection;
            }

        }

        public function insertNewAnnouncement($data){
            $connection = $this->connect();

            $stmt = $connection->prepare("INSERT INTO announce(title,date,image,description,postedBy) VALUES(?,?,?,?,?)");
            $stmt->bind_param('sssss',$data['subject'],$data['date'],$data['image'],$data['content'],$data['username']);
            $stmt->execute();
        }

        public function announcementData(){
            $connection = $this->connect();

            $stmt = $connection->prepare("SELECT * FROM announce ORDER BY id DESC");
            $stmt->execute();
            
            $result = $stmt->get_result();

            return $result;
        }
        
        public function deleteAnnouncement($id){
            $connection = $this->connect();
            
            $stmt = $connection->prepare("DELETE FROM announce WHERE id=?");
            $stmt->bind_param('i',$id);
            $stmt->execute();
            
        }
        
    }