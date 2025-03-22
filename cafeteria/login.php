<?php
include_once "../includes/libhtml.php"

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= generateHead("Cafeteria", false); ?>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h1>Login</h1>
        <form method="post">
            <fieldset class="flex two">
                <label>
                    Email
                    <input type="email" placeholder="Email">
                </label>
                <label>
                    Password
                    <input type="password" placeholder="Password">
                </label>
            </fieldset>
            <button class="login-button">Login</button>
        </form>
    </div>

</body>

</html>