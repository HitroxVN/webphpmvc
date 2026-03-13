<?php
require_once __DIR__ . "/../../app/config/dbconnect.php";
require_once __DIR__ . "/../../app/models/Order.php";

// ==============================================
// Xac thuc request tu webhook (Nếu test forward tunnel thì comment phần này lại)
$headers = getallheaders();

// print_r($headers);

$apiKey = $_ENV['SEPAY_WEBHOOK_KEY'] ?? '';

if (!isset($headers['Authorization'])) {
    http_response_code(401);
    exit('Missing API Key');
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

if ($token !== $apiKey) {
    http_response_code(403);
    exit('Invalid API Key');
}
// =================================================

// Nhan du liệu từ webhook
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

// log debug
file_put_contents('logs/sepay_webhook.log', date('Y-m-d H:i:s') . " - Data: " . $requestBody . PHP_EOL, FILE_APPEND);

if ($data) {
    $content = isset($data['content']) ? $data['content'] : ''; // Nội dung chuyển khoản
    $transferAmount = isset($data['transferAmount']) ? $data['transferAmount'] : 0; // Số tiền

    // check nội dung ckh
    if (preg_match('/order\s*(\d+)/i', $content, $matches)) {
        $orderId = intval($matches[1]);

        $orderModel = new Order();
        $order = $orderModel->getById($orderId);

        // penfing order
        if ($order && $order['status'] === 'pending') {
            if ($transferAmount >= $order['total_amount']) {
                // Cập nhập order (confirmed)
                $orderModel->updateStatus('confirmed', $orderId);
                echo json_encode(["success" => true, "message" => "Xác nhận thanh toán cho đơn hàng thành công."]);
                exit;
            } else {
                echo json_encode(["success" => false, "message" => "Số tiền thanh toán không đủ cho đơn hàng."]);
                exit;
            }
        } else {
            echo json_encode(["success" => false, "message" => "Đơn hàng không tồn tại hoặc đã được thanh toán/huỷ."]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "Không tìm thấy mã đơn hàng đúng định dạng trong nội dung."]);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "Invalid request. No data."]);
