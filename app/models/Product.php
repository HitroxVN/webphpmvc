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

    // Lấy danh sách sản phẩm admin
    public function getAll()
    {
        $sql = "SELECT p.*, c.name as category_name 
            FROM {$this->tableProduct} p 
            LEFT JOIN {$this->tableCategory} c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $rs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rs;
    }

    // lấy danh sách về trang home
    public function getAllHome()
    {
        $sql = "SELECT p.*, c.name as category_name 
            FROM {$this->tableProduct} p 
            LEFT JOIN {$this->tableCategory} c ON p.category_id = c.id 
            WHERE p.status = 'active'";
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
        // $sql = "UPDATE {$this->tableProduct} SET status='deleted' WHERE id=?";
        $sql = "DELETE FROM {$this->tableProduct} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $rs = $stmt->execute();
        $stmt->close();
        return $rs;
    }

    // Thêm sản phẩm mới
    public function create($category_id, $name, $description, $price, $status = 'active')
    {
        $sql = "INSERT INTO {$this->tableProduct} (category_id, name, description, price, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issds", $category_id, $name, $description, $price, $status);
        $stmt->execute();
        $rs = $this->conn->insert_id; // trả về id auto
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
            WHERE p.status = 'active' 
            ORDER BY p.created_at DESC 
            LIMIT 4";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $rs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rs;
    }

    // tìm kiếm sản phẩm
    public function findProduct($keyword = ''){
        // $sql = "SELECT * FROM products WHERE products.name LIKE ?";
        $sql = "SELECT p.*, c.name as category_name 
            FROM {$this->tableProduct} p 
            LEFT JOIN {$this->tableCategory} c ON p.category_id = c.id 
            WHERE p.status = 'active' and p.name like ?";
        $stmt = $this->conn->prepare($sql);
        $input = "%{$keyword}%";
        $stmt->bind_param("s", $input);
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_all(MYSQLI_ASSOC);
        return $p;
    }

    public function loc_gia($min = null, $max = null){
        $sql = "SELECT p.*, c.name as category_name 
            FROM {$this->tableProduct} p 
            LEFT JOIN {$this->tableCategory} c ON p.category_id = c.id 
            WHERE p.status = 'active'";

        $typedata = "";
        $bien = [];
        if(!empty($min)){
            $sql .= " and p.price >= ?";
            $typedata .= "d";
            $bien[] = $min;
        }
        if(!empty($max)){
            $sql .= " and p.price <= ?";
            $typedata .= "d";
            $bien[] = $max;
        }

        $stmt = $this->conn->prepare($sql);
        // $stmt->bind_param("dd", $min, $max);
        if(!empty($bien)){
            // tách thành tuwgnf biến
            $stmt->bind_param($typedata, ...$bien);
        }
        
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_all(MYSQLI_ASSOC);
        return $p;
    }

    // tìm kiếm sản phẩm trên trang admin
    public function findProductAdmin($keyword = ''){
        $sql = "SELECT p.*, c.name as category_name 
            FROM {$this->tableProduct} p 
            LEFT JOIN {$this->tableCategory} c ON p.category_id = c.id 
            WHERE p.name like ? or c.name like ?";
        $stmt = $this->conn->prepare($sql);
        $input = "%{$keyword}%";
        $stmt->bind_param("ss", $input, $input);
        $stmt->execute();
        $rs = $stmt->get_result();
        $p = $rs->fetch_all(MYSQLI_ASSOC);
        return $p;
    }
}
