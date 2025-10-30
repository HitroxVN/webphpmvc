<?php
require_once __DIR__ . "/../config/dbconnect.php";

class ProductImage
{
    private $conn;
    private $table = 'product_images';

    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    //  cập nhập thuộc tính ảnh của sản phẩm
    public function setPrimary($product_id, $primary)
    {
        $sql = "UPDATE {$this->table} SET is_primary = ? WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $primary, $product_id);
        $stmt->execute();
        $stmt->close();
    }

    // cập nhập ảnh chính
    public function updatePrimary($id, $primary)
    {
        $sql = "UPDATE {$this->table} SET is_primary = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $primary, $id);
        $stmt->execute();
        $stmt->close();
    }

    // lấy ảnh theo id sẩn phẩm
    public function getByProductId($product_id)
    {
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

    // lấy url ảnh chính theo id sẩn phẩm
    public function getPrimaryImage($product_id)
    {
        $sql = "SELECT image_url FROM {$this->table} WHERE product_id = ? AND is_primary = TRUE LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ? $row['image_url'] : null;
    }

    //lấy url theo id
    public function getUrlById($id)
    {
        $sql = "SELECT image_url FROM {$this->table} WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ? $row['image_url'] : null;
    }

    //lấy list url ảnh phụ
    public function getUrlByProduct($pid)
    {
        $sql = "SELECT image_url FROM {$this->table} WHERE product_id = ? and is_primary = false";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $row;
    }

    // thêm ảnh
    public function create($product_id, $image_url, $is_primary)
    {
        $sql = "INSERT INTO {$this->table} (product_id, image_url, is_primary) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("isi", $product_id, $image_url, $is_primary);
        $rs = $stmt->execute();

        $stmt->close();
        return $rs;
    }

    // xoá ảnh
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);
        $rs = $stmt->execute();

        $stmt->close();
        return $rs;
    }
}
