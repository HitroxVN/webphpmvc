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
    public function getTotalUser()
    {
        $sql = "SELECT COUNT(id) as total FROM users WHERE STATUS != 'deleted'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->get_result();
        $c = $rs->fetch_assoc();
        $stmt->close();
        return $c['total'] ?? 0;
    }

    // lấy tổng sản phẩm
    public function getTotalProduct()
    {
        $sql = "SELECT COUNT(id) as total FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_assoc();
        $stmt->close();

        return $p['total'] ?? 0;
    }

    // lấy tổng đơn hàng
    public function getTotalOrder($start_date = null, $end_date = null)
    {
        $sql = "SELECT COUNT(id) as total FROM orders";
        if ($start_date && $end_date) {
            $sql .= " WHERE DATE(created_at) BETWEEN ? AND ?";
        }
        $stmt = $this->conn->prepare($sql);
        if ($start_date && $end_date) {
            $stmt->bind_param('ss', $start_date, $end_date);
        }
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_assoc();
        $stmt->close();

        return $p['total'] ?? 0;
    }

    // doanh thu tính theo đơn hàng  ('confirmed','shipped','delivered')
    public function getTotalProfit()
    {
        $sql = "SELECT SUM(total_amount) AS doanhthu FROM orders WHERE status IN ('confirmed','shipped','delivered')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_assoc();
        $stmt->close();

        return $p['doanhthu'] ?? 0;
    }

    public function getDayRangeProfit($start_date = null, $end_date = null)
    {

        $sql = "SELECT SUM(total_amount) AS doanhthu 
            FROM orders 
            WHERE status IN ('confirmed','shipped','delivered')";

        if ($start_date && $end_date) {
            $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
        }

        $stmt = $this->conn->prepare($sql);

        if ($start_date && $end_date) {
            $stmt->bind_param("ss", $start_date, $end_date);
        }

        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_assoc();
        $stmt->close();

        return $p['doanhthu'] ?? 0;
    }

    // lấy top sản phẩm bán nhiều nhất
    public function getTopProduct($soluong, $start_date = null, $end_date = null)
    {
        $sql = "SELECT p.id, p.name, SUM(oi.quantity) AS total_sell, SUM(oi.quantity * oi.price) AS total_doanhthu 
        FROM order_items oi 
        JOIN product_variants pv ON oi.variant_id = pv.id 
        JOIN products p ON pv.product_id = p.id 
        JOIN orders o ON oi.order_id = o.id ";

        if ($start_date && $end_date) {
            $sql .= " WHERE DATE(o.created_at) BETWEEN ? AND ? ";
        }

        $sql .= " GROUP BY p.id, p.name ORDER BY total_sell DESC LIMIT ?";

        $stmt = $this->conn->prepare($sql);

        if ($start_date && $end_date) {
            $stmt->bind_param('ssi', $start_date, $end_date, $soluong);
        } else {
            $stmt->bind_param('i', $soluong);
        }
        $stmt->execute();

        $rs = $stmt->get_result();
        $top = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $top;
    }

    // lấy tất cả trạng thái đơn hàng
    public function getAllStatusOrder($start_date = null, $end_date = null)
    {
        $sql = "SELECT status, COUNT(*) AS total FROM orders ";
        if ($start_date && $end_date) {
            $sql .= " WHERE DATE(created_at) BETWEEN ? AND ? ";
        }
        $sql .= " GROUP BY status";

        $stmt = $this->conn->prepare($sql);
        if ($start_date && $end_date) {
            $stmt->bind_param('ss', $start_date, $end_date);
        }
        $stmt->execute();

        $rs = $stmt->get_result();
        $st = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $st;
    }

    public function getProfitByDay($start_date = null, $end_date = null)
    {
        $sql = "SELECT DATE(created_at) AS day, SUM(total_amount) AS doanhthu
            FROM orders
            WHERE status IN ('confirmed','shipped','delivered')";

        if ($start_date && $end_date) {
            $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
        } else {
            $startDate = date('Y-m-d', strtotime("-6 days"));
            $sql .= " AND created_at >= ?";
        }

        $sql .= " GROUP BY day ORDER BY day ASC";

        $stmt = $this->conn->prepare($sql);
        if ($start_date && $end_date) {
            $stmt->bind_param('ss', $start_date, $end_date);
        } else {
            $stmt->bind_param('s', $startDate);
        }
        $stmt->execute();

        $rs = $stmt->get_result();
        $st = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $st;
    }

}