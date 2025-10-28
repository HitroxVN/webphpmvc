<?php
//model
require_once __DIR__ . "/../config/dbconnect.php";

class Category {

    private $conn;
    private $table = 'categories';

    // khoi tao connect
    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    // lấy tất cả danh mục active và hide
    public function getAll() {
        $sql = "select * from {$this->table} where status != 'deleted'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $category;
    }

    // chỉ danh mục active
    public function getAllHome() {
        $sql = "select * from {$this->table} where status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $category;
    }

    // thêm danh mục mới
    public function create($name) {
        $sql = "INSERT INTO {$this->table} (name) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $category = $stmt->execute();
        $stmt->close();
        return $category;
    }

    // Cập nhật danh mục
    public function update($id, $name, $st = 'active') {
        $sql = "UPDATE {$this->table} SET name = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $st, $id);
        $category = $stmt->execute();
        $stmt->close();
        return $category;
    }

    // Xóa danh mục
    public function delete($id) {
        // $sql1 = "DELETE FROM {$this->table} WHERE id = ?";
        $sql = "update {$this->table} set status = 'deleted' where id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $category = $stmt->execute();
        $stmt->close();
        return $category;
    }

}