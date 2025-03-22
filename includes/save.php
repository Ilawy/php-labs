<?php
// will be executed if the method is post
require_once "./includes/validate.php";
require_once "./includes/sec_code.php";
require_once "./includes/utils.php";
require_once "./includes/db.php";
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
        'security_code' => validate(key: "security_code", custom: fn($v) => [validateSecurityCode($v), "Please make sure you wrote the code"]), //[false, ""]
        'first_name' => validate("first_name", true, true, "/.{3,}/", message: "First name should be at least 3 characters"), //[true, ""]
        'last_name' => validate("last_name", true, true, "/.{3,}/"),
        'address' => validate("address", true, true, "/.{5,}/"),
        'country' => validate("country", true, true),
        'department' => validate("department", true, true),
        'username' => validate("username", true, true),
        'gender' => validate("gender", true, true, pattern: "/male|female/"),
    ];
    $hasErrors = array_find($result, fn($field) => $field[0] == false);
    if ($hasErrors) {
        $errors = getValidationErrors($result);
        $values = getValidationValues($result);
        var_dump($values);
        $_SESSION['errors'] = $errors;
        $_SESSION['values'] = $values;

        header("Location: /");
        exit;
    }
    $final = getValidationValues($result);
    $GLOBALS['result'] = $final;
    $GLOBALS['skills'] = isset($_POST['skills']) ? $_POST['skills'] : [];
    insertRow(array_merge(
        pick($final, ["first_name", "last_name", "address", "country", "gender", "username", "department"]),
        [
            'skills' => isset($_POST['skills']) ? $_POST['skills'] : [],
            "id" => generateID()
        ]
    ));
    require_once "success.php";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    post_process();
    exit;
}
