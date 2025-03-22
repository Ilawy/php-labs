<?php
require_once "lib/validator.php";
require_once "lib/db.php";
require_once "lib/files.php";

$db = new Database("users");


$validationResult = [
    'name' => validate(
        'name',
        pattern: "/[A-Za-z ]{3,}/"
    ),
    'email' => validate(
        "email",
        custom: fn($email) => [filter_var($email, FILTER_VALIDATE_EMAIL), "Please enter a valid email address"],
    ),
    'password' => validate(
        "password",
        pattern: "/[0-9a-z_]{8,}/",
        message: "Password should be at least 8 characters, contains only 0-9, a-z and underscode"
    ),
    'password-confirm' => validate(
        "password-confirm",
    ),
    'room' => validate("room", pattern: "/app-1|app|-2|cloud/")
];

$errors = getValidationErrors($validationResult);
$values = getValidationValues($validationResult);
if (count($errors)) {
    $_SESSION["errors"] = $errors;
    $_SESSION["values"] = $values;
    header("Location: /register");
    exit;
}

// check for password confirmation
if ($values["password"] != $values["password-confirm"]) {
    $message = "Fields should be identical";
    $_SESSION["errors"] = ["password" => $message, "password-confirm" => $message];
    $_SESSION["values"] = $values;
    header("Location: /register");
    exit;
}

list($profilePicSuccess, $profilePicFileOrError) = validateFile("profile-pic", allowedExts: ["svg", "jpg", "jpeg", "png"]);
if (!$profilePicSuccess) {
    $_SESSION["errors"] = ['prifile-pic' => $profilePicFileOrError];
    $_SESSION["values"] = $values;
    header("Location: /register");
    exit;
}


$userExists = $db->findRow(fn($row) => $row["email"] == $values["email"]);
if ($userExists) {
    $_SESSION["errors"] = ["_" => "User already exists"];
    $_SESSION["values"] = $values;
    header("Location: /register");
    exit;
}

$profilePicPath = saveFile($profilePicFileOrError);

$db->insertRow(
    array_merge(
        pick($values, ["name", "email", "room"]),
        [
            "password" => password_hash($values["password"], PASSWORD_BCRYPT),
            "profilePic" => $profilePicPath,
            "id" => $db->generateID()
        ]
    )
);

$_SESSION["register"] = true;
header("Location: /thanks");
exit;

