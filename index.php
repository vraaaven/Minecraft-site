<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use App\Core\Route as Route;

require "vendor/autoload.php";
require "debug.php";

$route = new Route();

$route->run();
