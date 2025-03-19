<div class="checkboxes">
<?php
    $skills = ["PHP", "MySQL", "J2SE", "PostgreSQL"];

    foreach ($skills as $skill) {
        echo "
        <label class=checkbox>
            <input value='{$skill}' name='skills[$skill]' type=checkbox />
            {$skill}
        </label>";
    }
?>
</div>