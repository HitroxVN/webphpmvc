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

    // Chặn admin và staff truy cập trang home
    public static function checkHome()
    {
        Session::start();

        // chưa đăng nhập
        if (!isset($_SESSION['user']['role'])) {
            return;
        }

        $role = $_SESSION['user']['role'];

        switch ($role) {
            case 'admin':
                header("Location: admin/");
                exit;

            case 'staff':
                header("Location: staff/");
                exit;

            default:
                return;
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
