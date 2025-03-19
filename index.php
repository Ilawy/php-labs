<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once "./includes/sec_code.php";
require_once "./includes/libhtml.php";

require_once "./includes/post.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php generate_head(); ?>
    <style>
        form {
            max-width: 70ch;
            margin: 3rem auto;
        }
    </style>
</head>

<body>
    <form method="post">
        <!-- fname -->
        <div class="field">
            <label class="label">First name</label>
            <div class="control">
                <input required class="input" type="text" placeholder="John" name="first_name">
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "first_name" ? "Please check this field" : "" ?></p>
        </div>
        <!-- lname -->
        <div class="field">
            <label class="label">Last name</label>
            <div class="control">
                <input required class="input" type="text" placeholder="Doe" name="last_name">
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "last_name" ? "Please check this field" : "" ?></p>
        </div>
        <!-- address -->
        <div class="field">
            <label class="label">Address</label>
            <div class="control">
                <textarea required name="address" class="textarea"></textarea>
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "address" ? "Please check this field" : "" ?></p>
        </div>
        <!-- country -->
        <div class="field">
            <label class="label">Country</label>
            <div class="control">
                <div class="select">
                    <select required name="country">
                        <option value="" selected disabled>Select dropdown</option>
                        <?php require "./includes/countries.php" ?>
                    </select>
                </div>
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "country" ? "Please check this field" : "" ?></p>
        </div>
        <!-- gender -->
        <div class="field">
            <label class="label">Gender</label>
            <div class="control">
                <label class="radio">
                    <input type="radio" required value="male" name="gender" />
                    Male
                </label>
                <label class="radio">
                    <input type="radio" value="female" name="gender" />
                    Female
                </label>
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "gender" ? "Please check this field" : "" ?></p>
        </div>
        <!-- skills -->
        <div class="field">
            <label class="label">Skills</label>
            <div class="control">
                <?php require "./includes/skills.php"; ?>
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "skills" ? "Please check this field" : "" ?></p>
        </div>
        <!-- username -->
        <div class="field">
            <label class="label">Username</label>
            <div class="control">
                <input required class="input" type="text" placeholder="GoodMan2040" name="username">
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "username" ? "Please check this field" : "" ?></p>
        </div>
        <!-- department -->
        <div class="field">
            <label class="label">Department</label>
            <div class="control">
                <input required class="input" type="text" value="OpenSource" name="department">
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "department" ? "Please check this field" : "" ?></p>
        </div>
        <!-- verify code -->
        <div class="field">
            <label class="label">Security code</label>
            <h2 class="is-size-1" style="user-select: none;">
                <!-- SHOULD BE SEND AS IMAGE (IDK HOW, YET) -->
                <?php echo generateSecurityCode(); ?>
            </h2>
            <div class="control">
                <input required class="input" type="text" name="security_code">
            </div>
            <p class="help" style="color: red"><?php echo $_GET['why'] == "security_code" ? "Please check this field" : "" ?></p>
        </div>
        <div>
            <button>Submit</button>
            <button type="reset">Reset</button>
        </div>
    </form>

</body>

</html>