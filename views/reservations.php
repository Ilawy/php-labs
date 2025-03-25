<?php
include_once "lib/html.php";
include_once "lib/operations.php";
include_once "lib/validator.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once "handlers/create_reservation.handler.php";
    exit;
}

$maybeRows = getUserReservations((int)$_SESSION["id"]);

$availableRooms = getAvailableRooms() ?? [];

list($errors, $values) = getValidationReturn();
var_dump($errors);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= generateHead("Cafeteria", false); ?>
    <link rel="stylesheet" href="/static/style.css?3">
</head>

<body>

    <div class="container" x-data="{open: false}" x-init="$refs.modal.showModal()">
        <header>ChillCave</header>
        <div>
            <button x-on:click="$refs.modal.showModal(); open = true">Reserve a room</button>

            <dialog x-ref="modal" x-on:close="open = false">
                <form method="dialog" x-show="open" x-transition class="dialog-close">
                    <button>close</button>
                </form>
                <h2>New reservation</h2>
                <form method="post">
                    <fieldset class="flex two">
                        <label>
                            Room
                            <select name="room" required>
                                <option value="" disabled selected>Select room</option>
                                <?php
                                foreach ($availableRooms as $room) {
                                    $disabled = $room["occupied"] >= $room["capacity"] ? "disabled" : "";
                                    echo "<option $disabled value='{$room['id']}'>{$room['name']}</option>";
                                }
                                ?>
                            </select>
                        </label>
                        <label>
                            Start date
                            <input type="datetime-local" name="date" required>
                        </label>
                    </fieldset>
                    <fieldset class="flex two">
                        <label>
                            Duration
                            <input required value="1" min="1" max="6" type="number" name="duration">
                        </label>
                    </fieldset>
                    <button>Reserve</button>
                </form>
            </dialog>
        </div>
        <?php
        if (!is_null($maybeRows)) {
            if (count($maybeRows)) renderTable($maybeRows);
            else echo "No reservations found";
        } else {
            echo "cannot retrive reservations, try again later";
        }

        ?>

    </div>
    </div>

</body>

</html>