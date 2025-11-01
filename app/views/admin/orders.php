<section id="orders" class="mt-5">
    <h2 class="mb-3">Quản lý Đơn hàng</h2>
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
                <td><?php echo $o['id'];?></td>
                <td>Nguyễn Văn A</td>
                <td><?php echo number_format($o['total_amount'], 0, ',', '.'); ?> vnđ</td>
                <td><?php echo $o['status'];?></td>
                <td>
                    <button class="btn btn-success btn-sm me-1">Xác nhận</button>
                    <button class="btn btn-danger btn-sm">Hủy</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>