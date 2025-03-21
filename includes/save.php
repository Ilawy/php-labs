<?php
// will be executed if the method is post
require_once "./includes/validate.php";
require_once "./includes/sec_code.php";
require_once "./includes/utils.php";
function post_process()
{

    //1. valdiate security code
    // $security_code = validate("security_code", true, true);
    // if (!validateSecurityCode($security_code)) {
    //     $_SESSION['errors'] = ["security_code"];
    //     header("Location: /");
    //     exit;
    // }
    $result = [
        'security_code' => validate(key: "security_code", custom: fn($v) => [validateSecurityCode($v), "Please make sure you wrote the code"]),
        'first_name' => validate("first_name", true, true, "/.{3,}/", message: "First name should be at least 3 characters"),
        'last_name' => validate("last_name", true, true, "/.{3,}/"),
        'address' => validate("address", true, true, "/.{5,}/"),
        'country' => validate("country", true, true),
        'department' => validate("department", true, true),
        'gender' => validate("gender", true, true),
    ];
    $hasErrors = array_find($result, fn($field) => $field[0] == false);
    if ($hasErrors) {
        $missingFields = array_filter($result, function ($v, $k) {
            return $v[0] == false;
        }, ARRAY_FILTER_USE_BOTH);
        $missingFieldsWithMessage = array_map(fn($v) => $v[1], $missingFields);
        // $validFields = array_filter($result);
        // $_SESSION["valid"] = $validFields;
        $_SESSION['errors'] = $missingFieldsWithMessage;
        var_dump($missingFieldsWithMessage);

        // header("Location: /");
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
