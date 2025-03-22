<!-- https://tania.dev/the-simplest-php-router/ -->
<?php
require_once "lib/auth.php";

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
switch ($request) {
    case '/':
    case '':
        protect();
        require __DIR__ . '/views/index.php';
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
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
