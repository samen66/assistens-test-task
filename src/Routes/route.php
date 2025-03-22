<?php

use AssistensTestTask\Controllers\LoginController;
use AssistensTestTask\Controllers\RegisterController;
use AssistensTestTask\Controllers\UserController;
use AssistensTestTask\Middleware\AuthMiddleware;
use AssistensTestTask\Middleware\CsrfMiddleware;
use AssistensTestTask\Repository\UserRepository;
use AssistensTestTask\Routes\RouteHandler;
use AssistensTestTask\Security\CsrfProtection;
use AssistensTestTask\Services\Auth\Authenticator;
use AssistensTestTask\Services\Auth\SessionManager;
use AssistensTestTask\Services\UserService;

$basePath = str_replace('/public', '', dirname($_SERVER['SCRIPT_NAME']));
$uri = str_replace($basePath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));


// Настройки аутентификации
$sessionManager = new SessionManager();
$userService = new UserService(new UserRepository());
$authenticator = new Authenticator($sessionManager, $userService);
$csrfProtection = new CsrfProtection($sessionManager);
$userController = new UserController($userService);

// Middleware для проверки авторизации
$authMiddleware = new AuthMiddleware($authenticator);
$csrfMiddleware = new CsrfMiddleware($csrfProtection);

function redirect($url)
{
    header("Location: $url");
    exit();
}


// Проверка авторизации на главной странице
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php') {
    if (!$authenticator->check()) {
        redirect('/login'); // Редирект на /login, если пользователь не авторизован
    } else {
        redirect('/users-page');
    }
}

// Инициализация маршрутов
$routeHandler = new RouteHandler();

//Login
$routeHandler->add('POST', '/login', function () use ($authenticator) {
    $controller = new LoginController($authenticator);
    echo $controller->login($_POST['email'], $_POST['password']);
}, []);
$routeHandler->add('GET', '/login', function () use ($authenticator) {
    $controller = new LoginController($authenticator);
    echo $controller->getLoginPage(); // Отправляет содержимое login.html
}, []);

//Logout
$routeHandler->add('GET', '/logout', function () use ($authenticator) {
    $controller = new LoginController($authenticator);
    $controller->logout();
}, [$authMiddleware]);

//Registration
$routeHandler->add('POST', '/registration', function () use ($userService) {
    $controller = new RegisterController($userService);
    echo $controller->register($_POST['full_name'], $_POST['email'], $_POST['password']);
}, []);
$routeHandler->add('GET', '/registration', function () {
    echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/registration.html'); // Отправляет содержимое login.html
}, []);

$routeHandler->add('GET', '/', function () {
    echo json_encode(['message' => 'Добро пожаловать!']);
}, [$authMiddleware]); // Только для авторизованных пользователей

// User routes
$routeHandler->add('GET', '/users-page', function () use ($userController) {

    echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/users.html');
}, [$authMiddleware]);

$routeHandler->add('GET', '/user-page', function () use ($userController) {
    echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/user.html');
}, [$authMiddleware]);

$routeHandler->add('GET', '/users', function () use ($userController) {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 10;
    $userController->getAllUsers($page, $pageSize);
}, [$authMiddleware]);

$routeHandler->add('GET', '/user', function () use ($userController) {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $userController->getUser($id);
}, [$authMiddleware]);

$routeHandler->add('POST', '/user', function () use ($userController) {
    $userController->createUser();
}, [$authMiddleware]);

$routeHandler->add('PUT', '/user', function () use ($userController) {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $userController->updateUser($id);
}, [$authMiddleware]);

$routeHandler->add('DELETE', '/user', function () use ($userController) {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $userController->deleteUser($id);
}, [$authMiddleware]);

// Получение метода и URI запроса
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Диспетчуризация (обработка маршрутов)
$routeHandler->dispatch($method, $uri);