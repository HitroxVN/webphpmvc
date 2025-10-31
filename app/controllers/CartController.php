<?php

require_once __DIR__ . "/../models/Cart.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/ProductImage.php";
require_once __DIR__ . "/../models/ProductVariants.php";

class CartController extends Controller
{

    private $cart;
    private $product;
    private $image;
    private $variant;

    public function __construct()
    {
        $this->cart = new Cart();
        $this->product = new Product();
        $this->image = new ProductImage();
        $this->variant = new ProductVariant();
    }

    public function listCart($uid)
    {
        $cart = $this->cart->getCartByUser($uid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // xoá
            if (!empty($_POST['delete_cart'])) {
                $id = $_POST['delete_cart'];
                $this->cart->delete($id);
                $this->redirect('index.php?page=cart');
            }

            //thêm
            if (!empty($_POST['add_cart'])) {
                $vid = $_POST['add_cart'];
                $qty = max(1, ($_POST['quantity'] ?? 1));
                $uid = $_SESSION['user']['id'];
                $variant = $this->variant->getById($vid);
                // var_dump($variant);
                // echo $variant[0]['stock'];

                $maxStock = $variant[0]['stock'];

                if ($qty <= $maxStock) {
                    $this->cart->add($uid, $vid, $qty);
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit;
                } else {
                    echo '<script>
                        alert("Vượt quá số lượng tồn kho của sản phẩm");
                        window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";
                        </script>';
                    exit;
                }
            }

            // cập nhập cart
            if (!empty($_POST['update_cart']) && !empty($_POST['quantity'])) {
                foreach ($_POST['quantity'] as $cart_id => $qty) {
                    $this->cart->update($qty, $cart_id);
                }
                $this->redirect('index.php?page=cart');
            }
        }

        $this->view('home/cart', ['carts' => $cart]);
    }
}
