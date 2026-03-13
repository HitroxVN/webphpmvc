<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">
                    <h3 class="card-title text-primary mb-4">Thanh toán chuyển khoản</h3>
                    <p class="mb-4">Quét mã QR dưới đây bằng ứng dụng ngân hàng của bạn để thanh toán tự động.</p>

                    <?php
                    $bankBin = $_ENV['BANK_BIN'];
                    $bankAccount = $_ENV['BANK_ACCOUNT'];
                    $bankName = $_ENV['BANK_NAME'];
                    $amount = $order['total_amount'];
                    $description = 'order' . $order['id'];
                    // URL QR API tích hợp SePay
                    $qrUrl = "https://qr.sepay.vn/img?acc={$bankAccount}&bank={$bankBin}&amount={$amount}&des={$description}";
                    ?>

                    <div class="mb-4">
                        <img src="<?php echo $qrUrl; ?>" alt="QR Code Thanh Toán" class="img-fluid border rounded p-2"
                            style="max-width: 300px;">
                    </div>

                    <div class="bg-light p-3 rounded text-start mb-4">
                        <p class="mb-1"><strong>Ngân hàng:</strong> <?php echo $bankBin; ?></p>

                        <p class="mb-1"><strong>Số tài khoản:</strong> <?php echo $bankAccount; ?></p>

                        <p class="mb-1"><strong>Chủ tài khoản:</strong> <?php echo $bankName; ?></p>

                        <p class="mb-1">
                            <strong>Số tiền:</strong>
                            <span class="text-danger fw-bold">
                                <?php echo number_format($amount, 0, ',', '.'); ?> vnđ
                            </span>
                        </p>

                        <p class="mb-1">
                            <strong>Nội dung chuyển khoản:</strong>
                            <span class="text-primary fw-bold"><?php echo $description; ?></span>
                        </p>

                        <p class="mb-0 text-muted small">
                            Vui lòng giữ nguyên nội dung chuyển khoản để hệ thống xác nhận thanh toán tự động.
                        </p>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="index.php?page=orders" class="btn btn-outline-secondary">Quay lại đơn hàng</a>
                        <button class="btn btn-primary" onclick="window.location.reload()">Tôi đã thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Kiểm tra trạng thái thanh toán tự động sau mỗi 3 giây
    setInterval(function () {
        fetch('index.php?page=check_payment_status&id=<?php echo $order['id']; ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to success route
                    window.location.href = 'index.php?page=success-order';
                }
            })
            .catch(error => console.error('Error:', error));
    }, 3000);
</script>