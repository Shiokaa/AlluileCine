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
$router->get("/account", ['App\Controllers\UserController', 'showAccountPage']);
$router->get("/dashboard/delete/user/{id}", ['App\Controllers\UserController','handleUserDelete']);
/* ------------------------------- */

/* -------- Routage Movie --------- */
$router->get("/movies/{id}", ['App\Controllers\MovieController', 'showMoviePage']);
$router->get("/dashboard/delete/movie/{id}", ['App\Controllers\MovieController','handleMovieDelete']);
$router->get("/dashboard/addMovie", ['App\Controllers\MovieController','showAddMovieForm']);
$router->post("/dashboard/addMovie", ['App\Controllers\MovieController','handleAddMovie']);
/* ------------------------------- */

/* -------- Routage home --------- */
$router->get("/", ['App\Controllers\HomeController', 'showHomePage']);
/* ------------------------------- */

/* -------- Routage dashboard--------- */
$router->get("/dashboard", ['App\Controllers\DashboardController','showDashboard']);
/* ------------------------------- */
// On renvoie le router
return $router;
?>