<?php
require_once __DIR__ . "/../config/dbconnect.php";
class User
{
    private $conn;
    private $table = 'users';

    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    // lấy ds user
    public function getAll()
    {
        $sql = "SELECT * from {$this->table} where status != 'deleted'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $p = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $p;
    }

    // Cập nhật thông tin user
    public function update($id, $full_name, $email, $phone = null, $address = null, $role = 'customer', $status = 'active')
    {
        $sql = "UPDATE {$this->table} SET full_name = ?, email = ?, phone = ?, address = ?, role = ?, status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssi", $full_name, $email, $phone, $address, $role, $status, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // soft delete user 
    public function delete($id)
    {
        $sql = "UPDATE {$this->table} SET status = 'deleted', updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // lay user theo id
    public function getById($id)
    {
        $sql = "SELECT * from {$this->table} where id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $p = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $p;
    }
}
