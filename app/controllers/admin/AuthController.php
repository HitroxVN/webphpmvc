<?php
require_once __DIR__ . "/../../core/Controller.php";
require_once __DIR__ . "/../../models/User.php";

class AuthController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function loginAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $errors = [];

            // validate đầu vào của user
            if (empty($email)) $errors[] = "Vui lòng nhập email";
            if (empty($password)) $errors[] = "Vui lòng nhập mật khẩu";

            if (empty($errors)) {
                $u = $this->user->getByEmail($email);
                // có email trong db và ko bị xoá
                if ($u && $u['status'] != 'deleted' && $u['role'] === 'admin') {
                    if ($u['status'] != 'active') {
                        $errors[] = "Tài khoản đã bị khóa";
                    } elseif (password_verify($password, $u['password'])) {
                        $_SESSION['user'] = $u;
                        $this->redirect('index.php?page=home');
                        return;
                    } else {
                        $errors[] = "Sai mật khẩu";
                    }
                } else {
                    $errors[] = "Email không tồn tại";
                }
            }

            $this->view('auth/loginAdmin', [
                'errors' => $errors,
                'email' => $email
            ]);
        } else {
            $this->view('auth/loginAdmin', []);
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();

        $this->redirect('../index.php?page=home');
    }
}
