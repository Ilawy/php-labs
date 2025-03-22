<?php
include_once "lib/html.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "handlers/login.register.php";
    exit;
}

$errors = [];
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION["errors"]);
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
        <form method="post">
            <fieldset class="flex two">
                <label>
                    Name
                    <input type="name" name="name" placeholder="Email">
                    <span class="text-danger">
                        <?= $errors["name"] ?? "" ?>
                    </span>
                </label>
                <label>
                    Email
                    <input type="email" name="email" placeholder="Email">
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
                    Room NO.
                    <select name="room">
                        <option value="" selected disabled>Select an option</option>
                        <option value="app-1">Application 1</option>
                        <option value="app-2">Application 2</option>
                        <option value="cloud">Cloud</option>
                    </select>

                    <span class="text-danger">
                        <?= $errors["room"] ?? "" ?>
                    </span>
                </label>
                <label>
                    EXT
                    <input type="text" name="ext" placeholder="Ext">
                    <span class="text-danger">
                        <?= $errors["ext"] ?? "" ?>
                    </span>
                </label>
            </fieldset>
            <label>
                Profile pic.
                <input type="file">
            </label>
            <button class="login-button">Login</button>
        </form>
    </div>

</body>

</html>