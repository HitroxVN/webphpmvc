<?php
require_once __DIR__ . "/../../core/Controller.php";
require_once __DIR__ . "/../../models/Contact.php";

class ContactController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Contact();
    }

    // Xử lý GET hiển thị form và POST lưu dữ liệu
    public function xulyRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            $errors = [];

            if (empty($name)) $errors[] = "Vui lòng nhập họ và tên.";
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Vui lòng nhập email hợp lệ.";
            if (empty($message)) $errors[] = "Vui lòng nhập tin nhắn.";

            if (empty($errors)) {
                $saved = $this->model->create($name, $email, $message);
                if ($saved) {
                    // redirect để hiển thị thông báo thành công
                    $this->redirect('index.php?page=contact&success=1');
                    return;
                } else {
                    $errors[] = "Lưu không thành công. Vui lòng thử lại.";
                }
            }

            // Nếu có lỗi, render lại form kèm errors và dữ liệu cũ
            $this->view('home/contact', [
                'errors' => $errors,
                'old' => ['name' => $name, 'email' => $email, 'message' => $message]
            ]);
            return;
        }

        // GET: chỉ hiển thị view (nếu muốn có dữ liệu mặc định)
        $this->view('home/contact', []);
    }
}
