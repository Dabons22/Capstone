<?php 

    require '../model/adminModel.php';

    class AdminController{

        private $adminModel;

        public function __construct(){
            $this->adminModel = new AdminModel();
        }

        public function clean($data){
            $data = str_replace('/','',$data);
            $data = rtrim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);

            return $data;
        }

        public function isExist($username){
            $adminModel = $this->adminModel;

            if($adminModel->checkUsername($username) > 0 ){
                return true;
            }else{
                return false;
            }

        }
        
        public function isExistEmail($email){
            $adminModel = $this->adminModel;
            
            if($adminModel->checkEmail($email) > 0){
                return true;
            }else{
                return false;
            }
        }
        
        public function isExistContact($contact){
            $adminModel = $this->adminModel;
            
            if($adminModel->checkContact($contact) > 0){
                return true;
            }else{
                return false;
            }
        }

        public function addAccount($data){
            $adminModel = $this->adminModel;

            $cleanData = array(
                'username'=>$this->clean($data['username']),
                'password'=>password_hash($data['password'],PASSWORD_DEFAULT),
                'fullname'=>$this->clean($data['fullname']),
                'position'=>$this->clean($data['position']),
                'contact'=>$this->clean($data['contact']),
                'email'=>$this->clean($data['email'])
            );

            $adminModel->insertData($cleanData);
        }
        
        public function getAccount(){
            $adminModel = $this->adminModel;

            $data = $adminModel->account();

            return $data;
            
        }
        //Delete Account
        public function removeAccount($id){
            $adminModel = $this->adminModel;
            
            if($adminModel->deleteAccount($id)){
                return true;   
            }
            
        }
        
        //Update Account
        
        public function changeAccount($id,$position){
            $adminModel = $this->adminModel;
            
            if($adminModel->updateAccount($id,$position)){
                return true;
            }
        }
    }