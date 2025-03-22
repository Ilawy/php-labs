<?php
if (!isLoggedIn()) {
    header("Location: /login");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    require_once "views/not_found.php";
    exit;
}

session_destroy();
header("Location: /login");
exit;