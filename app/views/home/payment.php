<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Thanh toán chuyển khoản ngân hàng</h4>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-4">Quét mã QR dưới đây bằng ứng dụng Mobile Banking để thanh toán đơn hàng.
                    </p>

                    <div class="mb-4">
                        <?php
                        // VietQR format
                        $bank = 'MB'; // Bank Code, có thể cấu hình động
                        $account = 'truong320'; // Số tài khoản
                        $accountName = 'HOANG VAN TRUONG'; // Tên chủ tài khoản
                        $amount = $order['total_amount'];
                        $orderId = 'DH' . $order['id'];
                        $qrUrl = "https://img.vietqr.io/image/{$bank}-{$account}-compact.png?amount={$amount}&addInfo={$orderId}&accountName={$accountName}";
                        ?>
                        <img src="<?= $qrUrl ?>" alt="Mã QR Thanh toán" class="img-fluid border p-2 rounded"
                            style="max-width: 300px;">
                    </div>

                    <div class="alert alert-info text-start">
                        <strong>Thông tin chuyển khoản:</strong>
                        <ul class="list-unstyled mb-0 mt-2">
                            <li>Ngân hàng: <strong>
                                    <?= $bank ?>
                                </strong></li>
                            <li>Tên tài khoản: <strong>
                                    <?= $accountName ?>
                                </strong></li>
                            <li>Số tài khoản: <strong>
                                    <?= $account ?>
                                </strong></li>
                            <li>Số tiền: <strong class="text-danger">
                                    <?= number_format($amount, 0, ',', '.') ?> vnđ
                                </strong></li>
                            <li>Nội dung: <strong>
                                    <?= $orderId ?>
                                </strong> <span class="text-muted">(Bắt buộc)</span></li>
                        </ul>
                    </div>

                    <form method="post" action="index.php?page=payment&id=<?= $order['id'] ?>" class="mt-4">
                        <button type="submit" name="action" value="confirm_payment" class="btn btn-success btn-lg w-100"
                            onclick="return confirm('Bạn chắc chắn đã chuyển khoảng thành công chưa?')">
                            <i class="bi bi-check-circle me-2"></i> Tôi đã chuyển tiền
                        </button>
                    </form>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="index.php?page=orders" class="text-decoration-none">Quay lại danh sách đơn hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>