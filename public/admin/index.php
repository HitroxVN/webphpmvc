<?php
require_once __DIR__ . "/../../app/controllers/CategoryController.php";
require_once __DIR__ . "/../../app/controllers/ProductController.php";
require_once __DIR__ . "/../../app/controllers/UserController.php";
$cateC = new CategoryController();
$productC = new ProductController();
$userC = new UserController();
$adminpage = $_GET["page"] ?? "index";

// Nhận post 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['page'])) {
    switch ($adminpage) {
        case 'categorys':
            if (!empty($_POST['add_name'])) {
                $cateC->add();
            } elseif (!empty($_POST['action']) && !empty($_POST['id'])) {
                match ($_POST['action']) {
                    'save' => $cateC->edit(),
                    'delete' => $cateC->delete(),
                    default => null,
                };
            }
            break;

        case 'users':
            if (!empty($_POST['delete_id'])) {
                $userC->delete();
            }
            break;

        case 'products':
            if (!empty($_POST['delete_id'])) {
                $productC->delete();
            }
            break;
    }
}

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
                        $productC->list();
                        break;
                    case 'products_add':
                        $productC->add();
                        break;
                    case 'products_edit':
                        $productC->edit();
                        break;
                    case 'orders':
                        include_once __DIR__ . "/../../app/views/admin/orders.php";
                        break;
                    case 'users':
                        $userC->list();
                        break;
                    case 'user_edit':
                        $userC->edit();
                        break;
                    case 'categorys':
                        $cateC->list();
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