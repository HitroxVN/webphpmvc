<?php
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../core/Controller.php";

class DashboardController extends Controller
{
    private $productModel;
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->userModel = new User();
    }

    public function index()
    {
        // Lấy dữ liệu từ database
        $allProducts = $this->productModel->getAll();
        $allOrders = $this->orderModel->getAll();
        $allUsers = $this->userModel->getAll();

        // Tính toán thống kê
        $stats = [
            'total_products' => count($allProducts),
            'total_orders' => count($allOrders),
            'total_users' => count($allUsers),
            'total_revenue' => 0
        ];

        // Tính doanh thu và phân loại trạng thái
        $orderStatuses = ['pending' => 0, 'processing' => 0, 'shipped' => 0, 'delivered' => 0, 'cancelled' => 0];
        $monthlyRevenue = [];
        $dailyRevenue = [];

        foreach ($allOrders as $order) {
            // Tính doanh thu
            $stats['total_revenue'] += (float)$order['total_amount'];

            // Đếm trạng thái đơn hàng
            if (isset($orderStatuses[$order['status']])) {
                $orderStatuses[$order['status']]++;
            }

            // Doanh thu theo tháng
            if (!empty($order['created_at'])) {
                $month = date('Y-m', strtotime($order['created_at']));
                if (!isset($monthlyRevenue[$month])) {
                    $monthlyRevenue[$month] = 0;
                }
                $monthlyRevenue[$month] += (float)$order['total_amount'];

                // Doanh thu theo ngày (7 ngày gần nhất)
                $day = date('Y-m-d', strtotime($order['created_at']));
                if (!isset($dailyRevenue[$day])) {
                    $dailyRevenue[$day] = 0;
                }
                $dailyRevenue[$day] += (float)$order['total_amount'];
            }
        }

        // Lấy 6 tháng gần nhất
        ksort($monthlyRevenue);
        $last6Months = array_slice($monthlyRevenue, -6, 6, true);

        // Lấy 7 ngày gần nhất
        ksort($dailyRevenue);
        $last7Days = array_slice($dailyRevenue, -7, 7, true);

        // Thêm các ngày còn thiếu (ngày không có đơn hàng)
        $last7DaysComplete = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $last7DaysComplete[$date] = $last7Days[$date] ?? 0;
        }

        // Lấy sản phẩm bán chạy nhất (từ OrderItems)
        $topProducts = $this->getTopProducts();

        $this->view('admin/dashboard', [
            'stats' => $stats,
            'orderStatuses' => $orderStatuses,
            'monthlyRevenue' => $last6Months,
            'dailyRevenue' => $last7DaysComplete,
            'topProducts' => $topProducts
        ]);
    }

    // Lấy top 5 sản phẩm bán chạy nhất
    private function getTopProducts()
    {
        global $connect;
        $sql = "SELECT p.id, p.name, p.price, SUM(oi.quantity) as quantity_sold, SUM(oi.quantity * oi.price) as revenue
            FROM order_items oi
            JOIN product_variants pv ON oi.variant_id = pv.id
            JOIN products p ON pv.product_id = p.id
            GROUP BY p.id, p.name, p.price
            ORDER BY quantity_sold DESC
            LIMIT 5";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }
}
