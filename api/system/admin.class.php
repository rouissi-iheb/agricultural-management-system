<?php

require_once("database.class.php");
class Admin extends Database{
    function __construct()
    {
        parent::__construct();
    }
    function login($username,$password){
        $res = $this->pdo->prepare("select count(*) from admin where login = ? and password = ?");
        $res->execute(array($username,$password));
        $count = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["count(*)"];
        if($count>0){
            return true;
        }else{
            return false;
        }
    }
    function checkLogin(){
        if(isset($_SESSION) && isset($_SESSION['login'])){
            if($_SESSION['login'] == "connected"){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    function setLogin(){
        $_SESSION['login'] = "connected";
    }
    function logout(){
        $_SESSION['login'] = "";
    }
}

?>