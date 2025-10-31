<?php
require_once __DIR__ . "/../config/dbconnect.php";

class ProductVariant {
    private $conn;
    private $table = 'product_variants';

    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    //lấy thuộc tính sp theo id
    public function getByProductId($product_id) {
        $sql = "SELECT * FROM {$this->table} WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        return $data;
    }

    // lấy theo id
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        return $data;
    }


    // thêm thuộc tính
    public function create($product_id, $color, $size, $stock) {
        $sql = "INSERT INTO {$this->table} (product_id, color, size, stock) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("issi", $product_id, $color, $size, $stock);

        $rs = $stmt->execute();
        $stmt->close();

        return $rs;
    }

    // câp nhập tht
    public function update($color, $size, $stock, $product_id) {
        $sql = "UPDATE {$this->table} SET color = ?, size = ?, stock = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ssii", $color, $size, $stock, $product_id);

        $rs = $stmt->execute();
        $stmt->close();

        return $rs;
    }

    // xóa theo id
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);
        $rs = $stmt->execute();
        $stmt->close();

        return $rs;
    }
}
