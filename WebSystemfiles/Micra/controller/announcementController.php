<?php 

    require '../model/announcementModel.php';

    class AnnouncementController{

        private $announcementModel;
        
        public function __construct(){
            $this->announcementModel = new AnnouncementModel();
        }

        public function moveImage($image,$tmpfile){
            $target = '../resources/files/announcement/'.$image;
            move_uploaded_file($tmpfile,$target);
        }

        public function addAnnouncement($subject,$content,$image,$username,$date){
            $announcementModel = $this->announcementModel;
            $data = array(
                'subject'=>$subject,
                'content'=>$content,
                'image'=>$image,
                'username'=>$username,
                'date'=>$date
            );

            $announcementModel->insertNewAnnouncement($data);
        }

        public function getAnnouncement(){
            $announcementModel = $this->announcementModel;

            $data = $announcementModel->announcementData();

            return $data;
        }
        
        public function deleteAnnouncementById($id){
            $announcementModel = $this->announcementModel;
            
            $announcementModel->deleteAnnouncement($id);
            
        }
    }