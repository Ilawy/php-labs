<?php
require_once "pdo.php";
require_once "orm.php";
if (!isset($_SESSION) || is_null($_SESSION)) session_start();
function protect()
{
    if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
        header("Location: /login");
    }
}

function isLoggedIn(): bool
{
    return isset($_SESSION["login"]) && $_SESSION["login"] == true;
}

function login($email, $password)
{
    $pdo = null;
    try {
        // global $pdo;
        // $pdo = initPDO();
        // $userStmt = $pdo->prepare("select * from users where email = :email");
        // $userStmt->bindValue(":email", $email);
        // $userStmt->execute();
        // $user = $userStmt->fetch();
        $orm = new ORM();
        $user = $orm->selectOneFrom("users", ["*"], [Where::eq("email", $email)]);
        if (!$user) return null;

        if (password_verify($password, $user["password"])) {
            return $user;
        }
        $orm = null;
        return null;
    } finally {
        global $pdo;
        $pdo = null;
    }
}


function register($name, $email, $room, $password, $profilePic, ORM | null $orm = null)
{
    try {
        global $orm;
        // $pdo = initPDO();
        // $insertStmt = $pdo->prepare("insert into users (name, email, room, password, profilePic) values (:name, :email, :room, :password, :profilePic)");
        // $insertStmt->bindParam(":name", $name);
        // $insertStmt->bindParam(":email", $email);
        // $insertStmt->bindParam(":room", $room);
        // $insertStmt->bindValue(":password", password_hash($password, PASSWORD_BCRYPT));
        // $insertStmt->bindParam(":profilePic", $profilePic);
        // $insertStmt->execute();

        $row = compact("name", "email", "room", "profilePic");
        $row["password"] = password_hash($password, PASSWORD_BCRYPT);
        $orm = $orm ? $orm : new ORM();
        $orm->pdo->beginTransaction();
        $orm->insertInto("users", $row);
    } catch (Exception $e) {
        global $orm;
        if($orm && $orm->pdo->inTransaction())$orm->pdo->rollBack();
        $code = ($e->getCode());
        if ($code == "23000") {
            // duplicate
            throw new Exception("Email already exists");
        }
        throw $e;
    } finally {
       
    }
}


function deleteUser(int $id)
{
    $pdo = null;
    try {
        global $pdo;
        // $pdo = initPDO();
        $user = getUser($id);
        if (file_exists($user->profilePic)) {
            $picDeleted = unlink($user->profilePic);
            if (!$picDeleted) throw new Exception("Cannot delete profile picture");
        }
        // $deleteStmt = $pdo->prepare("delete from users where id = :id");
        // $deleteStmt->bindParam(":id", $id);
        // $deleteStmt->execute();
        // if ($deleteStmt->rowCount()) {
        //     return true;
        // } else {
        //     throw new Exception("User not found");
        // }
        $orm = new ORM();
        $orm->deleteFrom("users", [Where::eq("id", $id)]);
        $orm = null;
    } catch (Exception $e) {
        $code = ($e->getCode());
        throw $e;
    } finally {
        global $pdo;
        $pdo = null;
    }
}

class User
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string | null $room = null,
        public string $password,
        public string | null $profilePic = null,

    ) {}
}

function getUser($id, $pdo = null): User
{
    $shouldClose = is_null($pdo);
    try {
        // global $pdo;
        //? this will reuse an already initialized pdo object
        // if(!$pdo)$pdo = initPDO();
        // $selectStmt = $pdo->prepare("select * from users where id = :id");
        // $selectStmt->bindParam(":id", $id);
        // $selectStmt->execute();
        // $user = $selectStmt->fetch();
        $orm = new ORM();
        $user = $orm->selectOneFrom("users", ["*"], [Where::eq("id", $id)]);
        if (!$user) throw new Exception("User not found");
        return new User(
            id: $user["id"],
            name: $user["name"],
            email: $user["email"],
            room: $user["room"] ?? null,
            password: $user["password"],
            profilePic: $user["profilePic"] ?? null,
        );
        $orm = null;
    } catch (Exception $e) {
        $code = ($e->getCode());
        throw $e;
    } finally {
        global $pdo, $shouldClose;
        if ($shouldClose) $pdo = null;
    }
}


function updateUser(int $id, string | null $name = null, string | null $email = null, string | null $room = null)
{
    $pdo = null;
    try {
        global $pdo;
        // $pdo = initPDO();
        // $fields = [];
        // $params = [];
        // $params[":id"] = $id;
        // if (!is_null($name)) {
        //     $fields[] = "name = :name";
        //     $params[":name"] = $name;
        // }
        // if (!is_null($email)) {
        //     $fields[] = "email = :email";
        //     $params[":email"] = $email;
        // }
        // if (!is_null($room)) {
        //     $fields[] = "room = :room";
        //     $params[":room"] = $room;
        // }
        // $joinedFields = implode(", ", $fields);
        // $template = "update users set $joinedFields where id = :id";

        // $updateStmt = $pdo->prepare($template);
        // $updateStmt->execute($params);
        $orm = new ORM();
        $orm->updateFrom("users", compact("name", "email", "room"), [Where::eq("id", $id)]);
        $orm = null;
    } catch (Exception $e) {
        $code = ($e->getCode());
        if ($code == "23000") {
            // duplicate
            throw new Exception("Email already exists");
        }
        throw $e;
    } finally {
        global $pdo;
        $pdo = null;
    }
}
