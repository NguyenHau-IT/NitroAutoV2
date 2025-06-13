<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
//     $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//     header("Location: $redirect");
//     exit();
// }

require_once 'config/database.php';
require_once 'routes/web.php';
