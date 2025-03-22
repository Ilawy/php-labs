<?php
require_once "lib/validator.php";
require_once "lib/db.php";

$validationResult = [
    'name' => validate(
        'name',
        pattern: "/[A-Za-z ]{3}"
    ),
    'email' => validate(
        "email",
        custom: fn($email) => [filter_var($email, FILTER_VALIDATE_EMAIL), "Please enter a valid email address"],
    ),
    'password' => validate(
        "password", 
        pattern: "/[0-9a-z_]{8,}/", 
        message: "Password should be at least 8 characters, contains only 0-9, a-z and underscode")
];

$errors = getValidationErrors($validationResult);
if(count($errors)){
    $_SESSION["errors"] = $errors;
    header("Location: /login");
    exit;
}

$values = getValidationValues($validationResult);

$db = new Database("users");

$user = $db->findRow(fn($row)=>$row["email"] == $values["email"]);

if(is_null($user)){
    $_SESSION["errors"] = ["_" => "Email or password are invalid"];
    header("Location: /login");
    exit;
}
