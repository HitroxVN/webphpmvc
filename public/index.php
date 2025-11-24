<?php
ob_start();
require_once __DIR__ . "/../app/core/Session.php";
require_once __DIR__ . "/../app/controllers/users/CategoryController.php";
require_once __DIR__ . "/../app/controllers/users/ProductController.php";
require_once __DIR__ . "/../app/controllers/users/AuthController.php";
require_once __DIR__ . "/../app/controllers/users/UserController.php";
require_once __DIR__ . "/../app/controllers/users/CartController.php";
require_once __DIR__ . "/../app/controllers/users/CheckoutController.php";
require_once __DIR__ . "/../app/controllers/users/OrderController.php";
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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php $cateC->listHome(); ?>
    <?php 
        switch ($main) {
            case 'profile':
                Session::checkLogin() ? $userC->xulyRequest() : $authC->login();
                break;
            case 'category':
                $cateC->xulyRequest();
                break;
            case 'products':
                $productC->xulyRequest();
                break;
            case 'cart':
                Session::checkLogin() ? $cartC->xulyRequest() : $authC->login();
                break;
            case 'register':
                Session::checkLogin() ? $productC->home() : $authC->register();
                break;
            case 'login':
                Session::checkLogin() ? $productC->home() : $authC->login();
                break;
            case 'logout':
                $authC->logout();
                break;
            case 'checkout':
                Session::checkLogin() ? $checkoutC->xulyRequest() : $authC->login();
                break;
            case 'success-order':
                include_once __DIR__ . "/../app/views/home/success_order.php";
                break;
            case 'orders':
                Session::checkLogin() ? $orderC->xulyRequest() : $authC->login();
                break;
            default:
                $productC->home();
                break;
        }
    ?>
    <?php include_once __DIR__ . "/../app/views/home/nav.php"; ?>
    <?php include_once __DIR__ . "/../app/views/home/footer.php"; ?>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
ob_end_flush();
?>