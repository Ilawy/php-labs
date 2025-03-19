<?php
// will be executed if the method is post
require_once "./includes/validate.php";
require_once "./includes/sec_code.php";
function post_process()
{

    //1. valdiate security code
    $security_code = validate("security_code", true, true);
    if (!validateSecurityCode($security_code)) {
        header("Location: /?why=security_code");
        exit;
    }
    $result = [
        'first_name' => validate("first_name", true, true, "/.{3,}/"),
        'last_name' => validate("last_name", true, true, "/.{3,}/"),
        'address' => validate("address", true, true, "/.{5,}/"),
        'country' => validate("country", true, true),
        'department' => validate("department", true, true),
        'gender' => validate("gender", true, true),
    ];
    if(in_array(false, $result, true)){
        echo "we have validation error";
        exit;
    }
    $GLOBALS['result'] = $result;
    $GLOBALS['skills'] = $_POST['skills'];
    require_once "success.php";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    post_process();
    exit;
}
