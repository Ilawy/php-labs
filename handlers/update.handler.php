<?php
require_once "lib/utils.php";
require_once "lib/validator.php";

$id = $_REQUEST["PARAMS"][0];


$picked = pick($_POST, ["email", "name", "room"]);
$validationResult = [
    'name' => validate(
        "name",
        source: $picked,
        pattern: "/[A-Za-z ]{3,}/"
    ),
    'email' => validate(
        "email",
        source: $picked,
        custom: fn($email) => [filter_var($email, FILTER_VALIDATE_EMAIL), "Please enter a valid email address"],
    ),
    'room' => validate(
        "room",
        source: $picked,
        pattern: "/app-1|app-2|cloud/"
    )
];



$validationErrors = getValidationErrors($validationResult);
$values = getValidationValues($validationResult);

if (count($validationErrors)) {
    $_SESSION["errors"] = $validationErrors;
    $_SESSION["values"] = $values;
    header("Location: /edit/$id");
    exit;
}

try {
    updateUser($id, name: $values["name"], room: $values["room"], email: $values["email"]);
    header("Location: /edit/$id");
} catch (Exception $e) {
    $_SESSION["errors"] = ['_' => $e->getMessage()];
    header("Location: /edit/$id");
    exit;
}
