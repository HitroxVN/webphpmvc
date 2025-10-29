<?php

require_once __DIR__ . "/../../app/core/Session.php";
require_once __DIR__ . "/../../app/controllers/AuthController.php";

$authC = new AuthController();
$authC->loginAdmin();