<?php 
    
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    abstract class Database{

        protected $servername;
        protected $username;
        protected $password;
        protected $database;

        abstract protected function connect();
        
        public function __construct(){
            
            $this->servername = 'localhost';
            $this->username = 'id18437919_micradb';
            $this->password = 'Micradbthesis2@';
            $this->database = 'id18437919_micra';

        }
    }

?>