<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$envPath = __DIR__ . '/../../.env';
if (!file_exists($envPath)) {
    die(".env is require");
}

$env = parse_ini_file($envPath, false, INI_SCANNER_RAW);

$host = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$dbname = $env['DB_NAME'];
$port = (int)$env['DB_PORT'];

$connect = new mysqli($host, $username, $password, $dbname, $port);


if ($connect->connect_error) {
    die("Kết nối thất bại: " . $connect->connect_error);
}

