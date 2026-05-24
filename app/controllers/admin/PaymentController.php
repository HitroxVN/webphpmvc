<?php
require_once __DIR__ . "/../../models/Payment.php";
require_once __DIR__ . "/../../core/Controller.php";

class PaymentController extends Controller {
    private $payment;

    public function __construct()
    {
        $this->payment = new Payment();
    }

    public function xulyRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'update_status') {
                return $this->updateStatus();
            }
            if (isset($_POST['action']) && $_POST['action'] === 'delete') {
                return $this->delete();
            }
        }

        return $this->list();
    }

    public function list(){
        $payments = $this->payment->getAllPayments();
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);

        $this->view('admin/payments', [
            'payments' => $payments,
            'thongbao' => $thongbao
        ]);
    }

    public function updateStatus()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $bank_transaction_code = $_POST['bank_transaction_code'];
        
        $this->payment->updateStatus($bank_transaction_code, $status);
        $_SESSION['thongbao'] = "Cập nhật trạng thái thanh toán thành công";
        $this->redirect('index.php?page=payments');
    }

    public function delete()
    {
        $id = $_POST['id'];
        $this->payment->delete($id);
        $_SESSION['thongbao'] = "Xóa thông tin thanh toán thành công";
        $this->redirect('index.php?page=payments');
    }
}
