<?php
require_once __DIR__ . "/../config/dbconnect.php";

class Contact
{
    private $conn;
    private $tableContact = "contacts";

    public function __construct()
    {
        global $connect;
        $this->conn = $connect;
    }

    //get all contact
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->tableContact} ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $rs  = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rs;
    }

    public function create($name, $email, $message)
    {
        $sql = "INSERT INTO {$this->tableContact} (name, email, message) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("sss", $name, $email, $message);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
