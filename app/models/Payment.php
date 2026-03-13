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
}
