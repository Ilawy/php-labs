<?php
if(!isset($_SESSION) || is_null($_SESSION))session_start();
function protect(){
    if(!isset($_SESSION["login"]) || $_SESSION["login"] != true){
        header("Location: /login");
    }
}


function login($email, $password){
    
}