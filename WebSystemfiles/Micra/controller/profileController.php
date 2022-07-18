<?php

    require '../model/profileModel.php';
    
    class ProfileController{
        
        private $profileModel;
        
        public function __construct(){
            $this->profileModel = new ProfileModel();
        }
        
        public function getAccountData($id){
            $profileModel = $this->profileModel;
            
            $data = $profileModel->fetchProfileData($id);
            
            return $data;
        }
        
        public function changeProfile($id,$image){
            $profileModel = $this->profileModel;
            
            $profileModel->updateProfilePic($id,$image);

        }
    }