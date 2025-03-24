<?php
require_once "lib/validator.php";

list($idSuccess, $id) = validate("id", pattern: "/^\d+$/");

if(!$idSuccess){
    $_SESSION['errors'] = ['_' => "id is required"];
    header("Location: /list");
    exit;
}


if($_SESSION["id"] == $id){
    $_SESSION['errors'] = ['_' => "you can't delete yourself"];
    header("Location: /list");
    exit; 
}

try{
    deleteUser((int)$id);
    header("Location: /list");
    exit;
}catch(Exception $e){
    $_SESSION['errors'] = ['_' => $e->getMessage()];
    header("Location: /list");
    exit; 
}