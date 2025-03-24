<?php
require_once "config.php";


function initPDO(): ?PDO {
    $pdo = null;
    try{
        global $pdo;
        $connectionString = "mysql:host=". DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
        $pdo = new PDO($connectionString, DB_USER, DB_PASS);
    }catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
    return $pdo;
}