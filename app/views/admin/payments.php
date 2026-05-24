<section id="payments">
    <h2 class="mb-3">Quản lý Thanh toán</h2>

    <?php if (!empty($thongbao)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $thongbao ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Mã giao dịch</th>
                <th>Số tiền</th>
                <th>Ngày giao dịch</th>
                <th>Nội dung</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($payments)): ?>
                <tr>
                    <td colspan="9" class="text-center">Chưa có dữ liệu thanh toán nào.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($payments as $p): ?>
                    <tr>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $p['id']; ?>">
                            <input type="hidden" name="bank_transaction_code" value="<?= $p['bank_transaction_code']; ?>">
                            <input type="hidden" name="action" value="update_status">
                            <td><?php echo $p['id']; ?></td>
                            <td>
                                <a href="index.php?page=orders&id=<?php echo $p['order_id']; ?>">
                                    #<?php echo $p['order_id']; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $p['user_name'] ?? '<span class="text-muted">Ẩn danh</span>' ?>
                            </td>
                            <td><small><?php echo $p['bank_transaction_code']; ?></small></td>
                            <td><?php echo number_format($p['amount'], 0, ',', '.'); ?> vnđ</td>
                            <td><?php echo $p['transaction_date']; ?></td>
                            <td><?php echo $p['content']; ?></td>
                            <td>
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" <?php echo $p['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                    <option value="confirmed" <?php echo $p['status'] == 'confirmed' ? 'selected' : '' ?>>Thành công</option>
                                    <option value="failed" <?php echo $p['status'] == 'failed' ? 'selected' : '' ?>>Thất bại</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Xóa thông tin thanh toán này?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <!-- Modal trigger for raw payload -->
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#payloadModal<?= $p['id'] ?>">
                                    <i class="bi bi-info-circle"></i>
                                </button>
                            </td>
                        </form>
                    </tr>

                    <!-- Modal for Raw Payload -->
                    <div class="modal fade" id="payloadModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Chi tiết Payload giao dịch #<?= $p['bank_transaction_code'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <pre class="bg-light p-3"><code><?php 
                                        $json = json_decode($p['raw_payload'], true);
                                        echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 
                                    ?></code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>
