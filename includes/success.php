<?php require_once "./includes/libhtml.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo generateHead(); ?>
</head>

<body style="padding: 1rem;">
    <h1 class="is-size-1">
        Thanks
        <?php echo $GLOBALS['result']['gender'] == "male" ? "Mr." : "Miss." ?>
        <?php echo $GLOBALS['result']['first_name'] . " " . $GLOBALS['result']['last_name']; ?>
    </h1>
    <h2 class="is-size-2">
        Please review your details
    </h2>
    <p class="is-size-3">
        <b>Address</b>
        <?php echo $GLOBALS['result']['address']; ?>
    </p>
    <p class="is-size-3">
        <b>Your skills </b>
        <?php
        if (isset($GLOBALS["skills"]) && count($GLOBALS["skills"])) {
            echo join(", ", $GLOBALS["skills"]);
        } else {
            echo "<b>was not added.</b>";
        }
        ?>
    </p>
    <p class="is-size-3">
        <b>Department </b>
        <?php echo $GLOBALS['result']['department']; ?>
    </p>
    <a href="/display.php">Display all records</a>
</body>

</html>