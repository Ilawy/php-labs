<?php
include_once "lib/html.php";
include_once "lib/operations.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "handlers/update.handler.php";
    exit;
}

/**@var User $user */
$user = null;


try {
    global $user;
    $user = getUser((int)$_REQUEST["PARAMS"][0]);
} catch (Exception $e) {

    $_SESSION['errors'] = ['_' => $e->getMessage()];
    header("Location: /list");
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
        <div class="breadcrumb">
            <a href="/">Home</a>
            <span>></span>
            <a href="/list">All users</a>
            <span>></span>
            <a>user <?= $user->id ?></a>
        </div>
        <h1>Editing user</h1>
        <article class="card card-danger">
            <?= $errors["_"] ?? "" ?>
        </article>
        <form method="post" enctype="multipart/form-data">
            <h2>Personal Info</h2>
            <fieldset class="flex two">
                <label>
                    Name
                    <input value="<?= $user->name ?? "" ?>" type="name" name="name" placeholder="John Doe">
                    <span class="text-danger">
                        <?= $errors["name"] ?? "" ?>
                    </span>
                </label>
                <label>
                    Email
                    <input value="<?= $user->email ?? "" ?>" type="email" name="email" placeholder="mymail@yahoo.com">
                    <span class="text-danger">
                        <?= $errors["email"] ?? "" ?>
                    </span>
                </label>
            </fieldset>

            <fieldset class="flex two">
                <label>
                    Room NO.
                    <select name="room">
                        <option value="" selected disabled>Select an option</option>
                        <option <?= ($user->room ?? "") == "app-1" ? "selected" : ""  ?> value="app-1">Application 1</option>
                        <option <?= ($user->room ?? "") == "app-2" ? "selected" : ""  ?> value="app-2">Application 2</option>
                        <option <?= ($user->room ?? "") == "cloud" ? "selected" : ""  ?> value="cloud">Cloud</option>
                    </select>
                    <span class="text-danger">
                        <?= $errors["room"] ?? "" ?>
                    </span>
                </label>
                <!-- <label>
                    Profile pic.
                    <div>
                        <?php
                        if (!empty($user->profilePic)) {
                            echo "<div class='image-edit'>";
                            echo "<img src='/{$user->profilePic}' alt=''>";
                            echo "<button class='edit'>Remove photo</button>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <span class="text-danger">
                        <?= $errors["profile-pic"] ?? "" ?>
                    </span>
                </label> -->
            </fieldset>

            <button class="login-button">Update Info</button>
        </form>
        <!-- <form>
            <h2>Password update</h2>
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
            <button class="login-button">Update Password</button>
        </form> -->
        <form id="delete-form" method='post' action='/list'>
            <button form="delete-form" name="operation" value="delete" class="login-button error">Delete Account</button>
            <input type='hidden' name='id' value='<?= $user->id ?>'>
        </form>
    </div>

</body>

</html>