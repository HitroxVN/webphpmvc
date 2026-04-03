<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$envPath = __DIR__ . '/../../.env';
if (!file_exists($envPath)) {
    die(".env is require");
}

// composer autoload
require_once __DIR__ . '/../../vendor/autoload.php';

// Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];
$port = (int) $_ENV['DB_PORT'];

$connect = new mysqli($host, $username, $password, $dbname, $port);


if ($connect->connect_error) {
    die("Kết nối thất bại: " . $connect->connect_error);
}

