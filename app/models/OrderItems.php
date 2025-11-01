<?php
require_once __DIR__ . "/../config/dbconnect.php";

class OrderItems
{
    private $conn;
    private $table = 'order_items';

    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    // thêm sản phẩm vào đơn hàng
    public function add($oid, $vid, $qty, $p){
        $sql = "INSERT INTO {$this->table} (`order_id`, `variant_id`, `quantity`, `price`) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiid", $oid, $vid, $qty, $p);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

    // lấy thông tin sp theo order id
    public function getByOrderId($oid) {
        $sql = "SELECT oi.*, pv.size, pv.color, p.name AS product_name 
            FROM {$this->table} oi
            LEFT JOIN product_variants pv ON oi.variant_id = pv.id
            LEFT JOIN products p ON pv.product_id = p.id
            WHERE oi.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $oid);
        $stmt->execute();
        $rs = $stmt->get_result();
        $items = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $items;
}

}