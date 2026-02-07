<?php

use Phroute\Phroute\RouteCollector;


$router = new RouteCollector();

$router->get("/register", ['App\Controllers\UserController','showRegisterForm']);
$router->post("/register", ['App\Controllers\UserController','handleRegister']);


return $router;
?>