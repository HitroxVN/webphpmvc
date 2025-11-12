<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Cart.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../models/OrderItems.php";
require_once __DIR__ . "/../core/Controller.php";

class OrderController extends Controller {
    private $user;
    private $cart;
    private $order;
    private $order_item;

    public function __construct()
    {
        $this->user = new User();
        $this->cart = new Cart();
        $this->order = new Order();
        $this->order_item = new OrderItems();
    }

    public function xulyRequest(){
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            // xem chi tieets down hang
            if(!empty($_GET['id'])){
                $this->detailsAdmin();
            }
        } else {
            // cap nhap trang thai don hang
            if(!empty($_POST['status_update'])){
                $this->edit();
            }

        }

        $this->list();
    }
    // view for admin
    public function list(){
        $orders = $this->order->getAll();
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);

        $this->view('admin/orders', [
            'order' => $orders,
            'thongbao' => $thongbao
        ]);
    }

    // câp nhâp trạng thái
    public function edit(){
            $status = $_POST['status_update'];
            $oid = $_POST['order_id'];
            $this->order->updateStatus($status, $oid);
            $_SESSION['thongbao'] = "Cập nhập đơn hàng thành công";
            $this->redirect('index.php?page=orders');
    }

    public function detailsAdmin()
    {
        $id = $_GET['id'];
        $orders = $this->order->getById($id);
        $user = $this->user->getById($orders['user_id']);
        $order_items = $this->order_item->getByOrderId($id);

        $this->view('admin/order_details', [
            'order' => $orders,
            'user' => $user,
            'o_items' => $order_items
        ]);
    }

    // view for user
    public function listUser(){
        $uid = $_SESSION['user']['id'];
        $orders = $this->order->getByUser($uid);
        $this->view('home/order', ['order' => $orders]);
    }

    public function detailsId($id){
        $orders = $this->order->getById($id);
        $order_items = $this->order_item->getByOrderId($id);

        $this->view('home/order_details', [
            'order' => $orders,
            'o_items' => $order_items
        ]);
    }
}