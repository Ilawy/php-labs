<?php
    include_once "lib/html.php";
    if(isset($_SESSION["login"]) && $_SESSION["login"] == true){
        header("Location: /");
        exit;
    }
    if(!(isset($_SESSION["register"]) && $_SESSION["register"] == true)){
        header("Location: /login");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= generateHead("Cafeteria", false); ?>
    <link rel="stylesheet" href="/~static/style.css?3">
</head>
<body>

    <div class="container">
        <h1>Welcome to the club!</h1>
        <p>
            Your account has been created, please proceed to the <a href="/login">login</a> page
        </p>
    </div>

</body>
</html>