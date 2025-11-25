<section id="orders">
    <h2 class="mb-3">Quản lý Đơn hàng</h2>

    <form action="index.php" method="get">
        <input type="hidden" name="page" value="orders">
    <label>Lọc trạng thái đơn hàng</label><br>
    <select name="loc_orders">
        <option value="pending" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'pending' ? 'selected' : '' ?>>Chờ xác nhận</option>
        <option value="confirmed" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
        <option value="shipping" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'shipping' ? 'selected' : '' ?>>Đang giao hàng</option>
        <option value="shipped" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'shipped' ? 'selected' : '' ?>>Đã giao hàng</option>
        <option value="delivered" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'delivered' ? 'selected' : '' ?>>Đã nhận hàng</option>
        <option value="cancelled" <?php echo isset($_GET['loc_orders']) && $_GET['loc_orders'] == 'cancelled' ? 'selected' : '' ?>>Đã huỷ đơn</option>
        </select>
        <button type="submit">Lọc</button>
    </form>

    <?php if(!empty($thongbao)): ?>
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
            <?php foreach($order as $o): ?>
            <tr>
                <form method="post">
                <td><input type="hidden" name="order_id" value="<?= $o['id']; ?>"><?php echo $o['id'];?></td>
                <td><?php echo $o['full_name'] ?? '<span class="text-danger">Chưa có thông tin</span>' ?>
                <br> <span class="text-muted"><?php echo $o['email']; ?></span>    
            </td>
                <td><?php echo number_format($o['total_amount'], 0, ',', '.'); ?> vnđ</td>
                <td>
                    <select name="status_update" class="form-select form-select-sm">
                        <option value="pending" <?php echo $o['status'] == 'pending' ? 'selected':'' ?>>Chờ xác nhận</option>
                        <option value="confirmed" <?php echo $o['status'] == 'confirmed' ? 'selected':'' ?>>Đã xác nhận</option>
                        <option value="shipped" <?php echo $o['status'] == 'shipped' ? 'selected':'' ?>>Đã giao hàng</option>
                        <option value="shipping" <?php echo $o['status'] == 'shipping' ? 'selected':'' ?>>Đang giao hàng</option>
                        <option value="delivered" <?php echo $o['status'] == 'delivered' ? 'selected':'' ?>>Đã nhận hàng</option>
                        <option value="cancelled" <?php echo $o['status'] == 'cancelled' ? 'selected':'' ?>>Đã huỷ đơn</option>
                    </select>
                </td>
                <td>
                        <button class="btn btn-success btn-sm me-1" type="submit">Xác nhận</button>
                        <a class="btn btn-warning btn-sm" href="index.php?page=orders&id=<?php echo $o['id'];?>">Chi tiết</a>
                </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>