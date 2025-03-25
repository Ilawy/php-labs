<?php
include_once "lib/html.php";
include_once "lib/operations.php";
if (isLoggedIn()) {
    header("Location: /");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "handlers/register.handler.php";
    exit;
}

$errors = [];
$values = [];
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION["errors"]);
}
if (isset($_SESSION['values'])) {
    $values = $_SESSION['values'];
    unset($_SESSION["values"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= generateHead("Cafeteria", false); ?>
    <link rel="stylesheet" href="/~static/style.css">
</head>

<body>

    <div class="container">
        <h1>Register</h1>
        <article class="card card-danger">
            <?= $errors["_"] ?? "" ?>
        </article>
        <form method="post" enctype="multipart/form-data">
            <fieldset class="flex two">
                <label>
                    Name
                    <input value="<?= $values["name"] ?? "" ?>" type="name" name="name" placeholder="John Doe">
                    <span class="text-danger">
                        <?= $errors["name"] ?? "" ?>
                    </span>
                </label>
                <label>
                    Email
                    <input value="<?= $values["email"] ?? "" ?>" type="email" name="email" placeholder="mymail@yahoo.com">
                    <span class="text-danger">
                        <?= $errors["email"] ?? "" ?>
                    </span>
                </label>
            </fieldset>
            <fieldset class="flex two">
                <label>
                    Password
                    <input type="password" name="password" placeholder="Password">
                    <span class="text-danger">
                        <?= $errors["password"] ?? "" ?>
                    </span>
                </label>
                <label>
                    Confirm Password
                    <input type="password" name="password-confirm" placeholder="Password">
                    <span class="text-danger">
                        <?= $errors["password-confirm"] ?? "" ?>
                    </span>
                </label>
            </fieldset>
            <fieldset class="flex two">
                <label>
                    Profile pic.
                    <input type="file" name="profile-pic">
                    <span class="text-danger">
                        <?= $errors["profile-pic"] ?? "" ?>
                    </span>
                </label>
            </fieldset>

            <button class="login-button">Login</button>
        </form>
    </div>

</body>

</html>