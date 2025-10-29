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

    // getter / setter 
    public static function get($sess)
    {
        Session::start();
        return $_SESSION[$sess] ?? null;
    }
    public static function set($sess, $value)
    {
        Session::start();
        $_SESSION[$sess] = $value;
    }

    // xoá 1 session
    public static function remove($sess)
    {
        Session::start();
        if (isset($_SESSION[$sess])) unset($_SESSION[$sess]);
    }

    // xoá toàn bộ session
    public static function destroy()
    {
        Session::start();
        session_unset();
        session_destroy();
    }

    // lấy session hiện tại
    public static function getUser()
    {
        Session::start();
        return $_SESSION['user'] ?? null;
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
}
