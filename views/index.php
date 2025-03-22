<?php
    include_once "lib/html.php";
    include_once "lib/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= generateHead("Cafeteria", false); ?>
    <link rel="stylesheet" href="/~static/style.css?3">
</head>
<body>

    <div class="container">
        <h1>Welcome, <?= $_SESSION["name"] ?></h1>
        <img src="<?= $_SESSION["profilePic"] ?>" width="128" height="128" style="border-radius: 50%;" alt="">
        <p>
            You're seeing this page because you're a member in our system
        </p>
        <p>
            Howevere, you can logout below 
            <form method="post" action="logout"><button class="">Logout</button></form>
        </p>
    </div>

</body>
</html>