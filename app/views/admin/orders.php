<section id="orders">
    <h2 class="mb-3">Quản lý Đơn hàng</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="index.php" method="get" class="row g-3 align-items-center">
                <input type="hidden" name="page" value="orders">
                <div class="col-auto">
                    <label class="fw-bold"><i class="bi bi-funnel me-1"></i> Lọc trạng thái:</label>
                </div>
                <div class="col-md-4">
                    <select name="loc_orders" class="form-select">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="pending" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'pending' ? 'selected' : '' ?>>Chờ xác nhận</option>
                        <option value="confirmed" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                        <option value="shipping" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'shipping' ? 'selected' : '' ?>>Đang giao hàng</option>
                        <option value="shipped" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'shipped' ? 'selected' : '' ?>>Đã giao hàng</option>
                        <option value="delivered" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'delivered' ? 'selected' : '' ?>>Đã nhận hàng</option>
                        <option value="cancelled" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'cancelled' ? 'selected' : '' ?>>Đã huỷ đơn</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-filter"></i> Lọc
                    </button>
                    <?php if(!empty($_GET['loc_orders'])): ?>
                        <a href="index.php?page=orders" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($thongbao)): ?>
        <?php echo $thongbao ?>
    <?php endif; ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order as $o): ?>
                <tr>
                    <form method="post">
                        <td><input type="hidden" name="order_id" value="<?= $o['id']; ?>"><?php echo $o['id']; ?></td>
                        <td><?php echo $o['full_name'] ?? '<span class="text-danger">Chưa có thông tin</span>' ?>
                            <br> <span class="text-muted"><?php echo $o['email']; ?></span>
                        </td>
                        <td><?php echo number_format($o['total_amount'], 0, ',', '.'); ?> vnđ</td>
                        <td>
                            <select name="status_update" class="form-select form-select-sm">
                                <option value="pending" <?php echo $o['status'] == 'pending' ? 'selected' : '' ?>>Chờ xác nhận
                                </option>
                                <option value="confirmed" <?php echo $o['status'] == 'confirmed' ? 'selected' : '' ?>>Đã xác
                                    nhận</option>
                                <option value="shipped" <?php echo $o['status'] == 'shipped' ? 'selected' : '' ?>>Đã giao hàng
                                </option>
                                <option value="shipping" <?php echo $o['status'] == 'shipping' ? 'selected' : '' ?>>Đang giao
                                    hàng</option>
                                <option value="delivered" <?php echo $o['status'] == 'delivered' ? 'selected' : '' ?>>Đã nhận
                                    hàng</option>
                                <option value="cancelled" <?php echo $o['status'] == 'cancelled' ? 'selected' : '' ?>>Đã huỷ đơn
                                </option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm me-1" type="submit">Xác nhận</button>
                            <a class="btn btn-warning btn-sm" href="index.php?page=orders&id=<?php echo $o['id']; ?>">Chi
                                tiết</a>
                            <?php if ($o['status'] == 'pending'): ?>
                                <button type="submit" name="action" value="cancel" class="btn btn-danger btn-sm ms-1"
                                    onclick="return confirm('Huỷ đơn này?')">Huỷ</button>
                            <?php endif; ?>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>