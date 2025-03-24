<?php
require_once "lib/html.php";
require_once "lib/pdo.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST["operation"] ?? null;
    if ($operation == "delete") {
        require_once "handlers/delete.handler.php";
        exit;
    }
}

$rows = [];
$errors = [];
$total = 0;
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 0;


try {
    global $rows;
    $pdo = initPDO();
    $stmt = $pdo->prepare("select (select count(*) from users) as total, id, name, email, room, profilePic from users limit :limit offset :offset");
    $stmt->bindValue(":offset", $page * 10, PDO::PARAM_INT);
    $stmt->bindValue(":limit", 10, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = $rows[0]["total"];
    foreach ($rows as $key => $row) {
        $rows[$key]["actions"] = "
            <form method='post' action=''>
                <input type='hidden' name='id' value='{$row['id']}'>
                <button class='error' name='operation' value='delete'>Delete</button>
            </form>
            <a href='/edit/{$row['id']}'>Edit</a>
            ";
        $rows[$key]["profilePic"] = "<img src={$rows[$key]["profilePic"]} style='object-fit:contain;' height=64 width=64>";
        unset($rows[$key]["total"]);
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}



if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
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
            <a>All users</a>

        </div>
        <h1>Users list</h1>
        <article class="x-card card-danger"><?= $errors["_"] ?? "" ?></article>

        <?php
        renderTable($rows);
        if ($total > 10) {
            echo "<div class=pagination>";
            foreach (range(0, floor($total / 10)) as $value) {
                $disabled = ($page == $value) ? "disabled" : "";
                echo "<a $disabled href='/list?page=$value'>" . $value + 1 . "</a>";
            }
            echo "</div>";
        }
        ?>
    </div>

</body>

</html>