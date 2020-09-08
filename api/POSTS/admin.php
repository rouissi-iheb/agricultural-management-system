<?php
session_start();
set_time_limit(0);
if(isset($_GET)){
    require_once("../system/admin.class.php");
    $admin = new Admin();
    

    //if user posted data for login : 
    
    if(isset($_GET["login"])){
        $login = $admin->login($_POST['username'],$_POST['password']);
        if($login){
            $admin->setLogin();
            header("location:../../index.php");
        }else{
            header("location:../../login.php?error");
        }
     //if user posted data for other things   
    }elseif(isset($_GET["logout"])){
        $admin->logout();
        header("location:../../login.php");
    }else{
        exit();
    }
}

?>