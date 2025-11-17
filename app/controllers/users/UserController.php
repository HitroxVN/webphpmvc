<?php
require_once __DIR__ . "/../../models/User.php";
require_once __DIR__ . "/../../core/Controller.php";

class UserController extends Controller
{
    private $p;

    public function __construct()
    {
        $this->p = new User();
    }

    public function xulyRequest(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            return $this->update();
        }

        return $this->info();
    }

    public function info(){
        $this->view('home/profile', ['user' => $_SESSION['user']]);
    }

    public function update()
    {
        $u = $_SESSION['user'];
        $email = $u['email']; // session email hiện tại
        $id = $_POST['id'];

        // cho phép null nếu để trống (trừ email)
        $full_name = trim($_POST['full_name'] ?? '') ?: null;
        $phone = trim($_POST['phone'] ?? '') ?: null;
        $address = trim($_POST['address'] ?? '') ?: null;
        $input_email = trim($_POST['email'] ?? '');

        $notify = [];

        // validate email 
        if($input_email === ''){
            $notify['fail'] = "Email ko đc để trống";
            $this->view("home/profile", [
                'user' => $u,
                'notify' => $notify
            ]);
            return;
        }

        // check email trùng lặp
        $checkEmail = $this->p->getByEmail($input_email);
        if ($input_email != $email && $checkEmail) { // chỉ kiểm tra khi đổi email
            $notify['fail'] = "Email này đã tồn tại";
            $this->view("home/profile", [
                'user' => $u,
                'notify' => $notify
            ]);
            return;
        }

        // cập nhập bình thường
        $success = $this->p->update($id, $full_name, $email, $phone, $address, $u['role'], $u['status']);
        if ($success) {
            $new = $this->p->getByEmail($email);
            $_SESSION['user'] = $new;
            $notify['ok'] = "Cập nhập thông tin thành công";
        } else {
            $notify['fail'] = "Cập nhật thất bại";
        }

        $this->view("home/profile", [
            'user' => $new,
            'notify' => $notify
        ]);

    }

}
