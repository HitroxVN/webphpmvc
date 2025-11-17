<?php

// dùng static toàn cục cho all class
class Session
{
    // khởi tạo và check session 
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // kiểm tra session login
    public static function checkLogin(): bool
    {
        Session::start();
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

    // kiểm tra session login admin
    public static function checkAdminLogin()
    {
        Session::start();

        if (!isset($_SESSION['user']['role'])) {
            header('Location: login.php');
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: ../index.php');
            exit;
        }
    }

    // kiểm tra Staff
    public static function checkStaffLogin()
    {
        Session::start();

        if (!isset($_SESSION['user']['role'])) {
            header('Location: login.php');
            exit;
        }

        if ($_SESSION['user']['role'] !== 'staff') {
            header('Location: ../index.php');
            exit;
        }
    }
}
