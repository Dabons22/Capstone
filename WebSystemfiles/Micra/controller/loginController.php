<?php

    include '../model/loginModel.php';

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    class LoginController{

        protected $username;
        protected $password;
        private $loginModel;

        public function __construct(){
            $this->loginModel = new LoginModel();
        }
        
        public function setData($username,$password){
            $this->username = $username;
            $this->password = $password;
        }

        public function login(){

            return $this->loginModel->processLogin($this->username,$this->password);

        }

        public function setSession(){
            $data = $this->login();

            if($data != false || !empty($data)){

                $_SESSION['username'] = $data['username'];
                $_SESSION['id'] = $data['id'];
                $_SESSION['position'] = $data['position'];
                $_SESSION['fullname'] = $data['fullname'];
                $_SESSION['emails'] = $data['emails'];
                $_SESSION['contact'] = $data['contact'];
            
                return true;

            }else{

                return false;
            }
        }
        
        //Get Email or Contact from user then Check if it exist

        public function checkEmail($email){
            $loginModel = $this->loginModel;

            $data = $loginModel->email($email);

            if($data === 1){
                return true; 
            }else{
                return false;
            }
        }

        public function checkContact($contact){
            $loginModel = $this->loginModel;

            $data = $loginModel->contact($contact);

            if($data === 1){
                return true;
            }else{
                return false;
            }
        }
        
        //Get the new Pass and Update it
        
        public function usingEmail($pass,$email){
            $loginModel = $this->loginModel;
            
            $password = password_hash($pass,PASSWORD_DEFAULT);
            
            $data = $loginModel->updateByEmail($password,$email);
        }
        
        public function usingContact($pass,$contact){
            $loginModel = $this->loginModel;
            
            $password = password_hash($pass,PASSWORD_DEFAULT);
            
            $data = $loginModel->updateByEmail($password,$contact);
        }
        
        //Inserting and Updating Logs
        
        public function loginTime($username){
            $loginModel = $this->loginModel;
            
            date_default_timezone_set('Asia/Taipei');
            $date = date('F d, Y');
            $login = date('h:i:s a');
            
            $loginModel->insertLogin($username,$date,$login);
            
            $_SESSION['logintime'] = $login;
            $_SESSION['logindate'] = $date;
            
        }
        
        public function logoutTime($username,$date,$login){
            $loginModel = $this->loginModel;
            
            date_default_timezone_set('Asia/Taipei');
            $logout = date('h:i:s a');
            
            $loginModel->insertLogout($username,$date,$login,$logout);
        }
        
        //Showing All Logs for Main ADMIN
        
        public function showLogs(){
            $loginModel = $this->loginModel;
            
            $data = $loginModel->selectLogs();
            
            return $data;
        }
        
        //show print
          public function showprint($id){
            $loginModel = $this->loginModel;
            
            $data = $loginModel->selectprint($id);
            
            return $data;
        }
        
        
        //Remove only one Log History
        
        public function removeOneLog($id){
            $loginModel = $this->loginModel;
            
            $loginModel->removeOneLog($id);
        }
        
        
        //Clear all Login and Logout History
        
        public function clearLogs(){
            $loginModel = $this->loginModel;
            
            $loginModel->removeLogData();
        }
    }
