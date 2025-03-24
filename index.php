<!-- https://tania.dev/the-simplest-php-router/ -->
<?php
require_once "lib/operations.php";
require_once "lib/orm.php";

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
switch ($request) {
    case '/':
    case '':
        protect();
        require __DIR__ . '/views/index.php';
        break;
    case '/list':
        protect();
        require __DIR__ . '/views/list.php';
        break;
    case '/login':
        require __DIR__ . '/views/login.php';
        break;
    case '/logout':
        require __DIR__ . '/views/logout.php';
        break;
    case '/register':
        require __DIR__ . '/views/register.php';
        break;
    case '/thanks':
        require __DIR__ . '/views/thanks.php';
        break;
    default:
        if(preg_match("/^\/edit\/(\d+)$/", $request, $match)){
            $_REQUEST["PARAMS"] = array_slice($match, 1);
            require __DIR__ . "/views/edit.php"; 
            break;
        }
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
