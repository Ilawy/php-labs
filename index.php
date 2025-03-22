<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once "./includes/sec_code.php";
require_once "./includes/libhtml.php";
require_once "./includes/countries.php";

require_once "./includes/save.php";

$formErrors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$formValues = isset($_SESSION['values']) ? $_SESSION['values'] : [];

if (isset($_SESSION['errors']) || isset($_SESSION['values'])) {
    unset($_SESSION['errors']);
    unset($_SESSION['values']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php generateHead(); ?>
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
                <input required value='<?= $formValues["first_name"] ?? "" ?>' class="input" type="text" placeholder="John" name="first_name">
            </div>
            <p class="help" style="color: red"><?php  echo isset($formErrors["first_name"]) ? $formErrors['first_name'] : ""; ?></p>
        </div>
        <!-- lname -->
        <div class="field">
            <label class="label">Last name</label>
            <div class="control">
                <input required value='<?= $formValues["last_name"] ?? "" ?>' class="input" type="text" placeholder="Doe" name="last_name">
            </div>
            <p class="help" style="color: red"><?php  echo isset($formErrors["last_name"]) ? $formErrors['last_name'] : ""; ?></p>
        </div>
        <!-- address -->
        <div class="field">
            <label class="label">Address</label>
            <div class="control">
                <textarea required name="address" class="textarea"><?= $formValues["address"] ?? "" ?></textarea>
            </div>
            <p class="help" style="color: red"><?php  echo isset($formErrors["address"]) ? $formErrors['address'] : ""; ?></p>
        </div>
        <!-- country -->
        <div class="field">
            <label class="label">Country</label>
            <div class="control">
                <div class="select">
                    <select required name="country">
                        <option value="" selected disabled>Select dropdown</option>
                        <?php renderCountires($formValues["country"] ?? null); ?>
                    </select>
                </div>
            </div>
            <p class="help" style="color: red"><?php  echo isset($formErrors["country"]) ? $formErrors['country']: ""; ?></p>
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
            <p class="help" style="color: red"><?php  echo isset($formErrors["gender"]) ? $formErrors['gender'] : ""; ?></p>
        </div>
        <!-- skills -->
        <div class="field">
            <label class="label">Skills</label>
            <div class="control">
                <?php require "./includes/skills.php"; ?>
            </div>
            <p class="help" style="color: red"><?php  echo isset($formErrors["skills"]) ? $formErrors['skills'] : ""; ?></p>
        </div>
        <!-- username -->
        <div class="field">
            <label class="label">Username</label>
            <div class="control">
                <input required class="input" type="text" placeholder="GoodMan2040" name="username">
            </div>
            <p class="help" style="color: red"><?php  echo isset($formErrors["username"]) ? $formErrors['username'] : ""; ?></p>
        </div>
        <!-- department -->
        <div class="field">
            <label class="label">Department</label>
            <div class="control">
                <input required class="input" type="text" value="OpenSource" name="department">
            </div>
            <p class="help" style="color: red"><?php  echo isset($formErrors["department"]) ? $formErrors['department'] : ""; ?></p>
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
            <p class="help" style="color: red"><?php  echo isset($formErrors["security_code"]) ? $formErrors['security_code'] : ""; ?></p>
        </div>
        <div>
            <button>Submit</button>
            <button type="reset">Reset</button>
        </div>
    </form>

</body>

</html>