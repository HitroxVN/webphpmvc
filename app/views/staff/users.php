<section id="users" class="mt-5">
    <h2 class="mb-3">Quản lý Người dùng</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <form method="post">
                            <td>
                                <?php echo $u['id']; ?>
                            </td>
                            <td><?php echo $u['full_name'] ?? '<span class="text-danger">Chưa có thông tin</span>'; ?></td>
                            <td><?php echo $u['email']; ?></td>
                            <td><?php echo $u['phone'] ?? '<span class="text-danger">Chưa có thông tin</span>'; ?></td>
                            <td><?php echo $u['address'] ?? '<span class="text-danger">Chưa có thông tin</span>'; ?></td>
                            <td>
                            <?php if ($u['status'] === 'active'): ?>
                                <span class="badge bg-success">Hoạt động</span>
                            <?php elseif ($u['status'] === 'banned'): ?>
                                <span class="badge bg-danger">Bị khoá</span>
                            <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?page=orders&user=<?php echo $u['id']; ?>" class="btn btn-warning btn-sm me-1" style="display:inline-block;">Xem list đơn hàng</a>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Không có người dùng nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>