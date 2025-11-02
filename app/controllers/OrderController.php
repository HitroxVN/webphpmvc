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

    // view for admin
    public function list(){
        $orders = $this->order->getAll();
        foreach($orders as &$o){
            $u = $this->user->getById($o['user_id']);
            $o['full_name'] = $u['full_name'];
        }

        // update trạng thái
        if($_SERVER['REQUEST_METHOD'] ===  'POST' && !empty($_POST['status_update']) && !empty($_POST['order_id'])){
            $status = $_POST['status_update'];
            $oid = $_POST['order_id'];
            $this->order->updateStatus($status, $oid);
            $this->redirect('index.php?page=orders');
        }

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $orders = $this->order->getById($id);
            $user = $this->user->getById($orders['user_id']);
            $order_items = $this->order_item->getByOrderId($id);

            $this->view('admin/order_details', [
                'order' => $orders,
                'user' => $user,
                'o_items' => $order_items
            ]);
            return;
            }
        $this->view('admin/orders', [
            'order' => $orders
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