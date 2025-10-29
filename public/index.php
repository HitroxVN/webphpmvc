<?php
ob_start();
require_once __DIR__ . "/../app/core/Session.php";
require_once __DIR__ . "/../app/controllers/CategoryController.php";
require_once __DIR__ . "/../app/controllers/ProductController.php";
require_once __DIR__ . "/../app/controllers/AuthController.php";
require_once __DIR__ . "/../app/controllers/UserController.php";
$cateC = new CategoryController();
$productC = new ProductController();
$authC = new AuthController();
$userC = new UserController();
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
                    $productC->home();
                }
                break;
            case 'category':
                echo "category page";
                break;
            case 'products':
                $productC->listProduct();
                break;
            case 'register':
                $authC->register();
                break;
            case 'login':
                $authC->login();
                break;
            case 'logout':
                $authC->logout();
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