<section id="users">
    <h2 class="mb-3">Quản lý Người dùng</h2>
    <form action="index.php" method="get">
        <input type="hidden" name="page" value="users">
<label>Lọc tài khoản theo role</label><br>
    <select name="loc_role">
        <option value="customer" <?php echo $_GET['loc_role'] == 'customer' ? 'selected' : '' ?>>Khách hàng</option>
        <option value="staff" <?php echo $_GET['loc_role'] == 'staff' ? 'selected' : '' ?>>Nhân viên</option>
        <option value="admin" <?php echo $_GET['loc_role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
    <button type="submit">Lọc</button>
    </form>
    

    <?php if (!empty($thongbao)): ?>
        <?php echo $thongbao ?>
    <?php endif; ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Vai trò</th>
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
                            <td><?php echo match ($u['role']) {
                                'admin' => '<span class="badge bg-success">Quản trị</span>',
                                'staff' => '<span class="badge bg-warning">Nhân viên</span>',
                                default => '<span class="badge bg-secondary">Khách hàng</span>'
                            } ?>
                            </td>
                            <td>
                            <?php if ($u['status'] === 'active'): ?>
                                <span class="badge bg-success">Hoạt động</span>
                            <?php elseif ($u['status'] === 'banned'): ?>
                                <span class="badge bg-danger">Bị khoá</span>
                            <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?page=users&action=edit&id=<?php echo $u['id']; ?>" class="btn btn-warning btn-sm me-1" style="display:inline-block;">Sửa</a>
                                <form method="POST" action="index.php?page=users" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                    <input type="hidden" name="delete_id" value="<?php echo $u['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
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