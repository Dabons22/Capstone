<?php 

    require '../model/userModel.php';
    
    class UserController{
        
        private $userModel;
        
        public function __construct(){
            $this->userModel = new UserModel();
        }
        
        public function getNotVerified(){
            $userModel = $this->userModel;
            
            $data = $userModel->userRegistration('No');
            
            return $data;
        }
        
        public function Verified(){
           $userModel = $this->userModel;
            
            $data = $userModel->yesVerified('Yes');
            
            return $data;
            
        }
        public function isVerified($id){
            $userModel = $this->userModel;
            
            $userModel->setVerified($id,'Yes');
            
        }
        //Remove only one Log History
        
        public function deleteAccount($id){
            $userModel = $this->userModel;
            
            $userModel->deleteAccount($id);
        }
    }