<?php

require_once __DIR__ . "/../../app/controllers/staff/AuthController.php";

$authC = new AuthController();
$authC->login();