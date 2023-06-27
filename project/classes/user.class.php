<?php
class user {
    public $dbObj = null;
    public $con = null;
    public $result = null;

    public function __construct(){
        $this->dbObj = new db;
        $this->con = $this->dbObj->dbcon;
    }


    public function userLogin($username, $password){
        $sql = "SELECT * FROM users WHERE username = BINARY('" . $username . "') AND userpass = PASSWORD('" . $password . "');";
    	$this->result = $this->dbObj->selectFunction($sql);
        if($this->result[0] != true){// userdata 
            $_SESSION['userStatus'] = 0;
            return array(0 => false, 'text' => 'Niet ingelogd!');
        } else {
            $_SESSION['userStatus'] = 1;
            return array(0 => true, 'text' => 'Ingelogd!');
        }
        return $this->dbObj;
    }
    public static function isUserLoggedIn(){// static function op w3
        if(!isset($_SESSION['userStatus'])){
            $_SESSION['userStatus'] = 0;
        } else {
            if($_SESSION['userStatus'] == 1){
            } else {
                $_SESSION['userStatus'] = 0;
            }
        }
    }

    public function registerUser($userNameFromPOST, $userPassFromPOST, $firstFromPOST, $lastFromPOST, $dateOfBirthFromPOST){
        $sql = "INSERT INTO users(username, userpass, firstname, lastname, birthday) VALUES('" . $userNameFromPOST . "', password('" . $userPassFromPOST . "'), '" . $firstFromPOST . "', '" . $lastFromPOST . "', '" . $dateOfBirthFromPOST . "');";
        return $this->dbObj->otherSqlFunction($sql);
    }

    public function logoutUser(){// static toevoegen
        if(isset($_SESSION)){
            $_SESSION['userStatus'] = 0;
        }
    }
}
?>  
   