<?php

    if($_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'])) {        
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location: /test-app/403.php' ) );
    }
    
    class Connection 
    { 
        private $host     = 'localhost'; 
        private $user     = 'root'; 
        private $password = ''; 
        private $dbname   = 'test_app_db'; 
       
        protected $connection;

        public function __construct() {  
            if(!isset($this->connection)) { 
                $this->connection = new mysqli($this->host , $this->user , $this->password , $this->dbname); 
            } 
            return $this->connection;
       } 
    }
?>