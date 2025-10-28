<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../core/Controller.php";

class UserController extends Controller
{
    private $p;

    public function __construct()
    {
        $this->p = new User();
    }

    // Lấy danh sách user về trang admin
    public function list()
    {
        $users = $this->p->getAll();
        $this->view('admin/users', ['users' => $users]);
    }

    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['edit_id'] ?? null;
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $role = $_POST['role'] ?? 'customer';
            $status = $_POST['status'] ?? 'active';

            if ($id) {
                $success = $this->p->update($id, $full_name, $email, $phone, $address, $role, $status);
                if ($success) {
                    $_SESSION['message'] = "Cập nhật người dùng thành công!";
                } else {
                    $_SESSION['error'] = "Cập nhật thất bại!";
                }
            }

            $this->redirect('index.php?page=users');
        }
        if (!empty($_GET['id'])){
            $id = $_GET['id'];
            $u = $this->p->getById($id);

            $this->view('admin/user_edit', ['user' => $u]);
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['delete_id'] ?? null;

            if ($id) {
                $success = $this->p->delete($id);
                if ($success) {
                    $_SESSION['message'] = "Xóa người dùng thành công!";
                } else {
                    $_SESSION['error'] = "Xóa thất bại!";
                }
            }
        }

        $this->redirect('index.php?page=users');
    }
}
