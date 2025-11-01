<?php
require_once __DIR__ . "/../config/dbconnect.php";

class Order
{
    private $conn;
    private $table = 'orders';

    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    // lay oder  theo id
    public function getById($oid){
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $oid);
        $stmt->execute();
        $rs = $stmt->get_result();
        $o = $rs->fetch_assoc();
        $stmt->close();
        return $o;
    }

    // lấy đon hàng theo user
    public function getByUser($uid){
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $rs = $stmt->get_result();
        $o = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $o;
    }

    // lấy tất cả đơn hàng
    public function getAll(){
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->get_result();
        $o = $rs->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $o;
    }

    // thêm đơn hàng
    public function add($uid, $address, $total, $pay = 'COD', $status = 'pending'){
        $sql = "INSERT INTO {$this->table} (`user_id`, `shipping_address`, `total_amount`, `payment_method`, `status`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isdss", $uid, $address, $total, $pay, $status);
        $stmt->execute();
        $oid = $this->conn->insert_id; // trả về auto increment id
        $stmt->close();
        return $oid;
    }

}