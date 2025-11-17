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
            if(!empty($_POST['edit_id'])){
                return $this->edit();
            } elseif(!empty($_POST['delete_id'])){
                return $this->delete();
            }
        } elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
            $a = $_GET['action'] ?? '';
            if(!empty($a) && $a === 'edit' && !empty($_GET['id'])){
                return $this->showFormEdit();
            }
        }

        return $this->list();
    }

    // Lấy danh sách user về trang admin
    public function list()
    {
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);
        $users = $this->p->getAll();
        $this->view('admin/users', ['users' => $users, 'thongbao' => $thongbao]);
    }

    // view form edit
    public function showFormEdit()
    {
        $id = $_GET['id'];
        $u = $this->p->getById($id);

        $this->view('admin/user_edit', ['user' => $u]);

    }

    // sửa thông tin, quyền của user
    public function edit()
    {
        $id = $_POST['edit_id'] ?? null;
        $full_name = trim($_POST['full_name'] ?? '') ?: null;
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '') ?: null;
        $address = trim($_POST['address'] ?? '') ?: null;
        $role = $_POST['role'] ?? 'customer';
        $status = $_POST['status'] ?? 'active';

        if($email === ''){
            $_SESSION['thongbao'] = "Cập nhật thất bại, email không được để trống";
            $this->redirect('index.php?page=users');
            return;
        }

        if ($id) {
            $success = $this->p->update($id, $full_name, $email, $phone, $address, $role, $status);
            if ($success) {
                $_SESSION['thongbao'] = "Cập nhật người dùng thành công!";
            } else {
                $_SESSION['thongbao'] = "Cập nhật thất bại!";
            }
        }

        $this->redirect('index.php?page=users');

    }

    // soft delete account
    public function delete()
    {
        $id = $_POST['delete_id'] ?? null;

        if ($id) {
            $success = $this->p->delete($id);
            if ($success) {
                $_SESSION['thongbao'] = "Xóa người dùng thành công!";
            } else {
                $_SESSION['thongbao'] = "Xóa thất bại!";
            }
        }

        $this->redirect('index.php?page=users');
    }
}
