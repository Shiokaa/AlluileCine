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
$router->post("/account/update-profile", ['App\Controllers\UserController','handleUpdateProfile']);
$router->post("/account/update-password", ['App\Controllers\UserController','handleUpdatePassword']);
$router->post("/dashboard/delete/user/{id}", ['App\Controllers\UserController','handleUserDelete']);
/* ------------------------------- */

/* -------- Routage Movie --------- */
$router->get("/movies/{id}", ['App\Controllers\MovieController', 'showMoviePage']);
$router->post("/dashboard/delete/movie/{id}", ['App\Controllers\MovieController','handleMovieDelete']);
$router->get("/dashboard/addMovie", ['App\Controllers\MovieController','showAddMovieForm']);
$router->post("/dashboard/addMovie", ['App\Controllers\MovieController','handleAddMovie']);
$router->get("/dashboard/movies/{id}/addSession", ['App\Controllers\MovieController','showAddSessionForm']);
$router->post("/dashboard/movies/{id}/addSession", ['App\Controllers\MovieController','handleAddSession']);

/* -------- Routage Reservation --------- */
$router->get("/reservations", ['App\Controllers\ReservationController', 'showUserReservations']);
$router->post("/reservation", ['App\Controllers\ReservationController', 'handleReservation']);
/* ------------------------------- */

/* -------- Routage home --------- */
$router->get("/", ['App\Controllers\HomeController', 'showHomePage']);
$router->get("/contact", ['App\Controllers\HomeController', 'showContactPage']);
/* ------------------------------- */

/* -------- Routage dashboard--------- */
$router->get("/dashboard", ['App\Controllers\DashboardController','showDashboard']);
/* ------------------------------- */

// On renvoie le router
return $router;