<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Cart.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../core/Controller.php";

class CheckoutController extends Controller {
    private $user;
    private $cart;
    private $order;

    public function __construct()
    {
        $this->user = new User();
        $this->cart = new Cart();
        $this->order = new Order();
        
    }

    // view
    public function list(){
        $uid = $_SESSION['user']['id'];
        $address = $_SESSION['user']['address'];
        $users = $this->user->getById($uid);
        $carts = $this->cart->getCartByUser($uid);

        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['payment_method'])){
            // echo "test";
            $payment = $_POST['payment_method'];
            $this->order->add($uid, $address, $_POST['total'], $payment);
            $this->redirect('index.php?page=home');
        }

        $this->view('home/checkout', [
            'user' => $users,
            'cart' => $carts
        ]);
    }
}