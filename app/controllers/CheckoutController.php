<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Cart.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../models/OrderItems.php";
require_once __DIR__ . "/../core/Controller.php";

class CheckoutController extends Controller
{
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

    // view
    public function list()
    {
        $uid = $_SESSION['user']['id'];
        $address = $_SESSION['user']['address'];
        $users = $this->user->getById($uid);
        $carts = $this->cart->getCartByUser($uid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['payment_method'])) {
            // echo "test";
            $payment = $_POST['payment_method'];

            $oid = $this->order->add($uid, $address, $_POST['total'], $payment);
            
            foreach($carts as $c){
                $vid = $c['variant_id'];
                $qty = $c['quantity'];
                $price = $c['price'];
                $this->order_item->add($oid, $vid, $qty, $price);
            }

            $_SESSION['order_success'] = [
                'id' => $uid,
                'name' => $users['full_name'],
                'address' => $address,
                'payment' => $payment,
                'total' => $_POST['total'],
                'created_at' => date('d/m/Y H:i:s')
            ];
            $this->cart->deleteByUser($uid);
            $this->redirect('index.php?page=success-order');
        }

        $this->view('home/checkout', [
            'user' => $users,
            'cart' => $carts
        ]);
    }
}