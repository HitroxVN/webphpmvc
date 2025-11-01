<?php
require_once __DIR__ . "/../config/dbconnect.php";

class Cart
{
    private $conn;
    private $table = 'carts';

    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    // lấy ds giỏ hàng theo user id
    public function getCartByUser($uid)
    {
        $sql = "SELECT 
                c.id AS cart_id,
                c.quantity,
                pv.id AS variant_id,
                pv.size,
                pv.color,
                p.id AS product_id,
                p.name AS product_name,
                p.price,
                pi.image_url,
                cate.name AS category_name
            FROM {$this->table} c
            JOIN product_variants pv ON c.variant_id = pv.id
            JOIN products p ON pv.product_id = p.id
            JOIN categories cate ON p.category_id = cate.id
            LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
            WHERE c.user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        $rs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rs;
    }

    // xoá giỏ hàng
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

    // xoá giỏ hàng khi đặt
    public function deleteByUser($uid) {
        $sql = "DELETE FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $uid);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

    // thêm vào giỏ hàng
    public function add($uid, $vid, $q){
        $sql = "INSERT INTO {$this->table} (user_id, variant_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $uid, $vid, $q);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

    // cập nhập số lượng
    public function update($qty, $cid){
        $sql = "UPDATE {$this->table} SET `quantity` = ? WHERE `carts`.`id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $qty, $cid);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

}
