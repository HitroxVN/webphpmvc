<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Cart.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/ProductVariants.php";
require_once __DIR__ . "/../models/OrderItems.php";
require_once __DIR__ . "/../core/Controller.php";

class CheckoutController extends Controller
{
    private $user;
    private $cart;
    private $order;
    private $order_item;
    private $variant;
    private $product;

    public function __construct()
    {
        $this->user = new User();
        $this->cart = new Cart();
        $this->order = new Order();
        $this->variant = new ProductVariant();
        $this->order_item = new OrderItems();
        $this->product = new Product();
    }

    public function xulyRequest(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['payment_method'])){
                $this->taoOrders();
            }
        }
        $this->list();
    }

    // view
    public function list()
    {

        $uid = $_SESSION['user']['id'];
        $users = $this->user->getById($uid);

        $carts = [];

        if (!empty($_SESSION['checkout_product'])) {
            
            $variant = $this->variant->getById($_SESSION['checkout_product']['vid']);
            $p = $this->product->getById($_SESSION['checkout_product']['pid']);
            if($variant && $p){
            $carts = [
                [
                    'product_name' => $p['name'],
                    'size' => $variant['size'],
                    'color' => $variant['color'],
                    'quantity' => $_SESSION['checkout_product']['qty'],
                    'price' => $p['price'],
                    'image_url' => $variant['image_url'] ?? $variant['main_image'] ?? ''
                ]
            ];}
        } else {
            $carts = $this->cart->getCartByUser($uid);
        }

        $this->view('home/checkout', [
            'user' => $users,
            'cart' => $carts
        ]);
    }

    public function taoOrders(){
            // echo "test";
            $uid = $_SESSION['user']['id'];
            $address = $_SESSION['user']['address'];
            $phone = $_SESSION['user']['phone'];

            // bắt buộc thêm sđt, mail nhận hàng
            if(empty($address) || empty($phone)){
                // thêm session thông báo
                $this->redirect('index.php?page=profile');
                exit();
            }

            $users = $this->user->getById($uid);

            $carts = [];

        if (!empty($_SESSION['checkout_product'])) {
            $cp = $_SESSION['checkout_product'];
            $variant = $this->variant->getById($cp['vid']);
            $product = $this->product->getById($cp['pid']);

            if ($variant && $product) {
                $carts[] = [
                    'variant_id' => $cp['vid'],
                    'product_id' => $cp['pid'],
                    'size' => $variant['size'],
                    'color' => $variant['color'],
                    'quantity' => $cp['qty'],
                    'price' => $product['price']
                ];
            }
            unset($_SESSION['checkout_product']);
        } else {
            $carts = $this->cart->getCartByUser($uid);
        }
            
            $payment = $_POST['payment_method'];
            $total = $_POST['total']; // tổng tiền

            $oid = $this->order->add($uid, $address, $total, $payment);
            
            foreach($carts as $c){
                $vid = $c['variant_id'];
                $qty = $c['quantity'];
                $price = $c['price'];

                $v = $this->variant->getById($vid);
                $capnhap = max(0, $v['stock'] - $qty);

                $this->order_item->add($oid, $vid, $qty, $price);
                // câp nhập lại stock
                $this->variant->update($c['color'], $c['size'], $capnhap, $vid);
            }

            $_SESSION['order_success'] = [
                'id' => $oid,
                'name' => $users['full_name'],
                'address' => $address,
                'payment' => $payment,
                'total' => $_POST['total'],
                'created_at' => date('d/m/Y H:i:s')
            ];
            $this->cart->deleteByUser($uid);
            $this->redirect('index.php?page=success-order');
        
    }
}