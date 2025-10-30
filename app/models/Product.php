<?php
require_once __DIR__ . "/../config/dbconnect.php";

class Product
{
    private $conn;
    private $tableProduct = 'products';
    private $tableCategory = 'categories';


    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    // Lấy danh sách sản phẩm
    public function getAll()
    {
        $sql = "SELECT p.*, c.name as category_name 
            FROM {$this->tableProduct} p 
            LEFT JOIN {$this->tableCategory} c ON p.category_id = c.id 
            WHERE p.status != 'deleted'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $rs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rs;
    }


    // Xóa sản phẩm
    public function delete($id)
    {
        $sql = "UPDATE {$this->tableProduct} SET status='deleted' WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

    // Thêm sản phẩm mới
    public function create($category_id, $name, $description, $price)
    {
        $sql = "INSERT INTO {$this->tableProduct} (category_id, name, description, price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issd", $category_id, $name, $description, $price);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

    // Cập nhật sản phẩm
    public function update($id, $category_id, $name, $description, $price, $status)
    {
        $sql = "UPDATE {$this->tableProduct} 
                SET category_id = ?, name = ?, description = ?, price = ?, status = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issdsi", $category_id, $name, $description, $price, $status, $id);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

    // lấy sp theo id
    public function getById($id)
    {
        $sql = "SELECT p.*, c.name as category_name FROM {$this->tableProduct} p LEFT JOIN {$this->tableCategory} c ON p.category_id = c.id WHERE p.id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_assoc();
        $stmt->close();
        return $p;
    }

    // lấy san phẩm theo danh mục
    public function getByCategory($cid){
        $sql = "SELECT * FROM {$this->tableProduct} WHERE category_id = ? AND status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();
        $rs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rs;
    }

    // lấy ds sản phẩm mới nhất theo create-at
    public function getNewProduct()
    {
        $sql = "SELECT p.*, c.name AS category_name 
            FROM {$this->tableProduct} p 
            LEFT JOIN {$this->tableCategory} c ON p.category_id = c.id 
            WHERE p.status != 'deleted' 
            ORDER BY p.created_at DESC 
            LIMIT 4";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $rs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rs;
    }
}
