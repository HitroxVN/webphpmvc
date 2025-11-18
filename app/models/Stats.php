<?php
require_once __DIR__ . "/../config/dbconnect.php";

class Stats
{
    private $conn;

    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    // lấy tổng số người dùng (trừ acc bị xoá)
    public function getTotalUser(){
        $sql = "SELECT COUNT(id) as total FROM users WHERE STATUS != 'deleted'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->get_result();
        $c = $rs->fetch_assoc();
        $stmt->close();
        return $c['total'] ?? 0;
    }

    // lấy tổng sản phẩm
    public function getTotalProduct(){
        $sql = "SELECT COUNT(id) as total FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_assoc();
        $stmt->close();

        return $p['total'] ?? 0;
    }

    // lấy tổng đơn hàng
    public function getTotalOrder(){
        $sql = "SELECT COUNT(id) as total FROM orders";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_assoc();
        $stmt->close();

        return $p['total'] ?? 0;
    }

    // doanh thu tính theo đơn hàng  ('confirmed','shipped','delivered')
    public function getTotalProfit(){
        $sql = "SELECT SUM(total_amount) AS doanhthu FROM orders WHERE status IN ('confirmed','shipped','delivered')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_assoc();
        $stmt->close();

        return $p['doanhthu'] ?? 0;
    }

    // lấy top sản phẩm bán nhiều nhất
    public function getTopProduct($soluong){
        $sql = "SELECT p.id, p.name, SUM(oi.quantity) AS total_sell, SUM(oi.quantity * oi.price) AS total_doanhthu 
        FROM order_items oi 
        JOIN product_variants pv ON oi.variant_id = pv.id 
        JOIN products p ON pv.product_id = p.id 
        GROUP BY p.id, p.name ORDER BY total_sell DESC LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $soluong);
        $stmt->execute();

        $rs = $stmt->get_result();
        $top = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $top;
    }

    // lấy tất cả trạng thái đơn hàng
    public function getAllStatusOrder(){
        $sql = "SELECT status, COUNT(*) AS total FROM orders GROUP BY status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->get_result();
        $st = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $st;
    }

    // lấy doanh thu theo tháng
    public function getProfitByMonth($months = 6){
        $startDate = date('Y-m-01', strtotime("-" . ($months - 1) . " months"));

        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, SUM(total_amount) AS doanhthu 
        FROM orders 
        WHERE created_at >= ?
        GROUP BY month ORDER BY month ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $startDate);
        $stmt->execute();

        $rs = $stmt->get_result();
        $st = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $st;
    }

    public function getProfitByDay($days = 7){
    $startDate = date('Y-m-d', strtotime("-" . ($days - 1) . " days"));

    $sql = "SELECT DATE(created_at) AS day, SUM(total_amount) AS doanhthu
            FROM orders
            WHERE created_at >= ?
            GROUP BY day
            ORDER BY day ASC";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param('s', $startDate);
    $stmt->execute();

    $rs = $stmt->get_result();
    $st = $rs->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $st; 
}


}