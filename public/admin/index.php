<?php
ob_start();
require_once __DIR__ . "/../../app/core/Session.php";
require_once __DIR__ . "/../../app/controllers/admin/CategoryController.php";
require_once __DIR__ . "/../../app/controllers/admin/ProductController.php";
require_once __DIR__ . "/../../app/controllers/admin/UserController.php";
require_once __DIR__ . "/../../app/controllers/admin/OrderController.php";
Session::checkAdminLogin();
$cateC = new CategoryController();
$productC = new ProductController();
$userC = new UserController();
$orderC = new OrderController();
$adminpage = $_GET["page"] ?? "index";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/main.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include_once __DIR__ . "/../../app/views/admin/sidebar.php"; ?>
            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-4 py-4">
                <?php
                switch ($adminpage) {
                    case 'products':
                        $productC->xulyRequest();
                        break;
                    case 'orders':
                        $orderC->xulyRequest();
                        break;
                    case 'users':
                        $userC->xulyRequest();
                        break;
                    case 'categorys':
                        $cateC->xulyRequest();
                        break;
                    default:
                        include_once __DIR__ . "/../../app/views/admin/dashboard.php";
                        break;
                }
                ?>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
ob_end_flush();
?>