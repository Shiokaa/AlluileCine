<?php

use Phroute\Phroute\RouteCollector;

// On initialise le router à l'aide de Phroute
$router = new RouteCollector();

/* -------- Routage user --------- */
$router->get("/register", ['App\Controllers\UserController','showRegisterForm']);
$router->post("/register", ['App\Controllers\UserController','handleRegister']);
$router->get("/login", ['App\Controllers\UserController', 'showLoginForm']);
$router->post("/login", ['App\Controllers\UserController','handleLogin']);
$router->get("/logout", ['App\Controllers\UserController', 'handleLogout']);
/* ------------------------------- */

/* -------- Routage home --------- */
$router->get("/", ['App\Controllers\HomeController', 'showHomePage']);
/* ------------------------------- */

// On renvoie le router
return $router;
?>