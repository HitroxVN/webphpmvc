<?php

require_once __DIR__ . "/../../models/Cart.php";
require_once __DIR__ . "/../../models/ProductVariants.php";

class CartController extends Controller
{

    private $cart;
    private $variant;

    public function __construct()
    {
        $this->cart = new Cart();
        $this->variant = new ProductVariant();
    }

    public function xulyRequest(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['delete_cart'])){
                $this->delete();
            } elseif(!empty($_POST['update_cart']) && !empty($_POST['quantity'])){
                $this->update();
            } elseif(!empty($_POST['add_cart']) && $_POST['action'] === 'addcart'){
                $this->add();
            } elseif(!empty($_POST['action']) && $_POST['action'] === 'buynow'){
                // echo "test";
                $_SESSION['checkout_product'] = [
                    'pid' => $_POST['product_id'],
                    'vid' => $_POST['add_cart'],
                    'qty' => $_POST['quantity']
                ];
                $this->redirect('index.php?page=checkout');
            }
        }

        $this->listCart();
    }

    // xoá sản phẩm
    public function delete(){
        $id = $_POST['delete_cart'];
        $this->cart->delete($id);
        $this->redirect('index.php?page=cart');
    }

    // update số lượng
    public function update(){
        foreach ($_POST['quantity'] as $cart_id => $qty) {
            $variant = $this->variant->getById($_POST['update_cart']);
            $maxStock = $variant['stock'];

            // kiểm tra tồn kho tại giỏ hàng
            if ($qty <= $maxStock) {
                $this->cart->update($qty, $cart_id);
            } else {
                // session thông báo
                echo '<script>
                        alert("Vượt quá số lượng tồn kho của sản phẩm");
                        window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";
                        </script>';
                exit;
            }

        }
        $this->redirect('index.php?page=cart');
    }

    // thêm vào giỏ hàng
    public function add(){
        $vid = $_POST['add_cart'];
        $qty = max(1, ($_POST['quantity'] ?? 1));
        $uid = $_SESSION['user']['id'];
        $variant = $this->variant->getById($vid);

        $maxStock = $variant['stock'];

        if ($qty <= $maxStock) {
            $this->cart->add($uid, $vid, $qty);
            $this->redirect("index.php?page=cart");
        } else {
            echo '<script>
                        alert("Vượt quá số lượng tồn kho của sản phẩm");
                        window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";
                        </script>';
            exit;
        }
    }

    // view cart
    public function listCart(){
        unset($_SESSION['checkout_product']);
        $cart = $this->cart->getCartByUser($_SESSION['user']['id']);
        $this->view('home/cart', ['carts' => $cart]);
    }
}
