<?php 
ob_start();
require_once __DIR__ . "/../../app/core/Session.php";
require_once __DIR__ . "/../../app/controllers/staff/OrderController.php";
require_once __DIR__ . "/../../app/controllers/staff/ProductController.php";
require_once __DIR__ . "/../../app/controllers/staff/UserController.php";
require_once __DIR__ . "/../../app/controllers/admin/StatsController.php";
Session::checkStaffLogin();
$orderC = new OrderController();
$productC = new ProductController();
$userC = new UserController();
$statsC = new StatsController();
$adminpage = $_GET["page"] ?? "home";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include_once __DIR__ . "/../../app/views/staff/sidebar.php"; ?>
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
                    default:
                    // dùng tạm của Admin dashboard
                        $statsC->list();
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