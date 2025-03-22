<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once "./includes/db.php";
require_once "./includes/libhtml.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php generateHead("Display") ?>
</head>

<body>
    <?php 
        $data = array_map(fn($row)=>array_merge($row, ['action'=>"<form action=delete.php method=post><button value={$row['id']} name='id'>Delete</button></form>"]), getAllRows());
        
    ?>
    <?php renderTable($data, ["first_name", "last_name", "action"]); ?>
</body>

</html>