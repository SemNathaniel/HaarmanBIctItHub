<?php
class db {
    public $dbcon = null;
    public $result = null;

    public function __construct(){
         if(!empty(DBHOST) && !empty(DBUSER) && !empty(DBNAME)){
            $this->dbcon = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        }
        if(!empty($this->dbcon->connect_error)){
            $error = $this->dbcon->connect_error;
            error_log($error .' CONNECT ERROR ON LINE 15 db.class.php ' . date('l jS \of F Y h:i:s A')); 
        } else {
        }
    }
    public function selectFunction($sql){
        if(!empty($sql)){
            $sql = trim($sql);
            if($this->result = $this->dbcon->query($sql)){
                if($this->result->num_rows > 0){
                    $records = $this->result->fetch_all();
                    if(!empty($records)){
                        return $records;
                    }
                } else {
                    return array(false ,'No records found');
                }
            } else {
                return array(false, 'Query failed' . $this->dbcon->error);
            }
        } else {
            return array(false, 'no query given');
        }
    }
    public function otherSqlFunction($sql){
        if(!empty($sql)){
            $sql = trim($sql);
            try{
                if($this->dbcon->query($sql)){
                    return array(true);
                }
            } catch(Exception){
                return array(false);
            }
        } else {
            return 'no query given';
        }
    }   
}
?>