<?php

use Config\DbConfig;
use Controller\eventController;
use controller\usercontroller;
use controller\reservationController;
use Routers\Router;


session_start();

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../routers/router.php';

require_once __DIR__ . '/../controller/eventController.php';
require_once __DIR__ . '/../controller/usercontroller.php';
require_once __DIR__ . '/../controller/reservationController.php';

$dbConfig = new DbConfig();
$pdo = $dbConfig->connect();

$userController = new usercontroller();
$eventController = new eventController();
$reservationController = new reservationController();

$router = new Router();


// User-specific routes
$router->addRoute('/logout', [$userController, 'logout']);
$router->addRoute('/user/profile', [$userController, 'showProfile']);
$router->addRoute('/', [$userController, 'showLogin']);

$router->addRoute('/authentication/login', [$userController, 'login']);
$router->addRoute('/logout', [$userController, 'logout']);
$router->addRoute('/register', [$userController, 'showRegister']);
$router->addRoute('/authentication/register', [$userController, 'register']);
$router->addRoute('/home', [$userController, 'showHome']);
$router->addRoute('/admin-home', [$userController, 'showAdminHome']);
$router->addRoute('/create-reservation', [$reservationController, 'createReservation']);
$router->addRoute('/delete/user', [$userController, 'deleteUser']);
$router->addRoute('/user/update', [$userController, 'updateUser']);
// Event-specific routes
$router->addRoute('/event/create', [$eventController, 'createEvent']);
$router->addRoute('/manage-event', [$eventController, 'getAllEvents']);
//$router->addRoute('/manage-event', [$eventController, 'getNewEvents']);

$router->addRoute('/event/view', [$eventController, 'viewEvent']);
$router->addRoute('/event/edit', [$eventController, 'editEvent']);
$router->addRoute('/delete/event', [$eventController, 'deleteEvent']);
$router->addRoute('/delete-reservation', [$reservationController, 'deleteReservation']);
$router->addRoute('/manage-reservations', [$reservationController, 'showManageReservations']);
// Handle the request
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->route($urlPath);


