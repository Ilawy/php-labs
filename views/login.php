<?php
include_once "lib/html.php";
include_once "lib/auth.php";
if(isLoggedIn()){
    header("Location: /");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "handlers/login.handler.php";
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
        <h1>Login</h1>
        <article class="card card-danger">
            <?= $errors["_"] ?? "" ?>
        </article>
        <form method="post">
            <fieldset class="flex two">
                <label>
                    Email
                    <input type="email" name="email" placeholder="Email">
                    <span class="text-danger">
                        <?= $errors["email"] ?? "" ?>
                    </span>
                </label>
                <label>
                    Password
                    <input type="password" name="password" placeholder="Password">
                    <span class="text-danger">
                        <?= $errors["password"] ?? "" ?>
                    </span>
                </label>
            </fieldset>
            <button class="login-button">Login</button>
        </form>
        <a href="/register">create an account</a>
    </div>

</body>

</html>