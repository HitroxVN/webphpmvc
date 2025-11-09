<?php
ob_start();
require_once __DIR__ . "/../app/core/Session.php";
require_once __DIR__ . "/../app/controllers/CategoryController.php";
require_once __DIR__ . "/../app/controllers/ProductController.php";
require_once __DIR__ . "/../app/controllers/AuthController.php";
require_once __DIR__ . "/../app/controllers/UserController.php";
require_once __DIR__ . "/../app/controllers/CartController.php";
require_once __DIR__ . "/../app/controllers/CheckoutController.php";
require_once __DIR__ . "/../app/controllers/OrderController.php";
$cateC = new CategoryController();
$productC = new ProductController();
$authC = new AuthController();
$userC = new UserController();
$cartC = new CartController();
$checkoutC = new CheckoutController();
$orderC = new OrderController();
$main = $_GET['page'] ?? 'home';
?>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>ShoeShop — Trang chủ</title>
    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once __DIR__ . "/../app/views/home/nav.php"; ?>
    <?php $cateC->listHome(); ?>
    <?php 
        switch ($main) {
            case 'profile':
                if(Session::checkLogin()){
                    $userC->showInfo();
                } else {
                    $authC->login();
                }
                break;
            case 'category':
                if(isset($_GET['id'])){
                    $cid = $_GET['id'];
                    $productC->listProductByCate($cid);
                }
                break;
            case 'products':
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $productC->productDetails($id);
                } else {
                    $productC->listProduct();
                }
                break;
            case 'cart':
                if(Session::checkLogin()){
                    $cartC->listCart($_SESSION['user']['id']);
                } else {
                    $authC->login();
                }
                break;
            case 'register':
                if(Session::checkLogin()){
                    $productC->home();
                } else {
                    $authC->register();
                }
                break;
            case 'login':
                if(Session::checkLogin()){
                    $productC->home();
                } else {
                    $authC->login();
                }
                break;
            case 'logout':
                $authC->logout();
                break;
            case 'checkout':
                if(Session::checkLogin()){
                    $checkoutC->list();
                } else {
                    $authC->login();
                }
                break;
            case 'success-order':
                include_once __DIR__ . "/../app/views/home/success_order.php";
                break;
            case 'orders':
                if(Session::checkLogin()){
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $orderC->detailsId($id);
                } else {
                    $orderC->listUser();
                }
            } else {
                $authC->login();
            }
                break;
            default:
                $productC->home();
                // echo "test pages";
                break;
        }
    ?>
    <?php include_once __DIR__ . "/../app/views/home/footer.php"; ?>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
ob_end_flush();
?>