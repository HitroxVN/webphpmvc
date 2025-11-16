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

}