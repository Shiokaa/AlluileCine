<?php

namespace App\Controllers;

class HomeController {

    public function __construct() {
        
    }

    public function showHomePage() {
        include_once __DIR__ . "/../Views/home.php";
    }
}

?>