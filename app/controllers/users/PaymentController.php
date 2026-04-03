<?php
require_once __DIR__ . "/../../models/Order.php";
require_once __DIR__ . "/../../core/Controller.php";

class PaymentController extends Controller
{
    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function xulyRequest()
    {
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?page=home');
            exit();
        }

        $oid = $_GET['id'];
        $orderInfo = $this->order->getById($oid);

        if (!$orderInfo || $orderInfo['user_id'] != $_SESSION['user']['id']) {
            $this->redirect('index.php?page=orders');
            exit();
        }

        if ($orderInfo['status'] != 'pending') {
            $this->redirect('index.php?page=orders');
            exit();
        }

        $this->view('home/payment', [
            'order' => $orderInfo
        ]);
    }

    public function checkStatus()
    {
        ob_clean();
        header('Content-Type: application/json');

        if (!isset($_GET['id'])) {
            echo json_encode(['success' => false]);
            exit();
        }
        $oid = $_GET['id'];
        $orderInfo = $this->order->getById($oid);
        if ($orderInfo && $orderInfo['status'] === 'confirmed') {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit();
    }
}
