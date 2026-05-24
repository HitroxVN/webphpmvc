<?php
require_once __DIR__ . "/../config/dbconnect.php";
class Payment
{
    private $conn;
    private $table = 'payments';
    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }
    public function create($order_id, $transaction_date, $bank_transaction_code, $amount, $content, $raw_payload)
    {
        $sql = "INSERT INTO {$this->table} (`order_id`, `transaction_date`, `bank_transaction_code`, `amount`, `content`, `raw_payload`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ississ", $order_id, $transaction_date, $bank_transaction_code, $amount, $content, $raw_payload);
        $payment = $stmt->execute();
        $stmt->close();
        return $payment;
    }

    public function existsByReference($bank_transaction_code)
    {
        $sql = "select id from {$this->table} where bank_transaction_code = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $bank_transaction_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $payment = $result->fetch_assoc();
        $stmt->close();
        return $payment;
    }

    public function updateStatus($referenceCode, $status)
    {
        $sql = "update {$this->table} set status = ? where bank_transaction_code = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $status, $referenceCode);
        $payment = $stmt->execute();
        $stmt->close();
        return $payment;
    }

    public function getAllPayments()
    {
        $sql = "SELECT p.*, o.user_id, u.full_name as user_name 
                FROM {$this->table} p
                LEFT JOIN orders o ON p.order_id = o.id
                LEFT JOIN users u ON o.user_id = u.id
                ORDER BY p.transaction_date DESC";
        $result = $this->conn->query($sql);
        $payments = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $payments[] = $row;
            }
        }
        return $payments;
    }

    public function getPaymentById($id)
    {
        $sql = "SELECT p.*, o.user_id, u.full_name as user_name 
                FROM {$this->table} p
                LEFT JOIN orders o ON p.order_id = o.id
                LEFT JOIN users u ON o.user_id = u.id
                WHERE p.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $payment = $result->fetch_assoc();
        $stmt->close();
        return $payment;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $status = $stmt->execute();
        $stmt->close();
        return $status;
    }
}
