<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Cart.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../core/Controller.php";

class OrderController extends Controller {
    private $user;
    private $cart;
    private $order;

    public function __construct()
    {
        $this->user = new User();
        $this->cart = new Cart();
        $this->order = new Order();
        
    }

    public function list(){
        $orders = $this->order->getAll();
        $users = $_SESSION['user'];

        $this->view('admin/orders', ['order' => $orders]);
    }
}