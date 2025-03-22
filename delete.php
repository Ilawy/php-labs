<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once "./includes/db.php";
require_once "./includes/libhtml.php";

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo "404 not found";
    http_response_code(404);
    exit;
}

if(!isset($_POST['id'])){
    $_SESSION['errors'] = ['_' => "id is required but not provided"];
    header("Location: /display.php");
    exit;
}

//for future use
$deleted = deleteRow((int)$_POST['id']);

header("Location: /display.php");

