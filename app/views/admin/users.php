<section id="users">
    <h2 class="mb-3">Quản lý Người dùng</h2>
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="index.php" method="get" class="row g-3 align-items-center">
                <input type="hidden" name="page" value="users">
                <div class="col-auto">
                    <label class="fw-bold"><i class="bi bi-person-badge me-1"></i> Lọc theo vai trò:</label>
                </div>
                <div class="col-md-3">
                    <select name="loc_role" class="form-select">
                        <option value="">-- Tất cả vai trò --</option>
                        <option value="customer" <?php echo isset($_GET['loc_role']) && $_GET['loc_role'] == 'customer' ? 'selected' : '' ?>>Khách hàng</option>
                        <option value="staff" <?php echo isset($_GET['loc_role']) && $_GET['loc_role'] == 'staff' ? 'selected' : '' ?>>Nhân viên</option>
                        <option value="admin" <?php echo isset($_GET['loc_role']) && $_GET['loc_role'] == 'admin' ? 'selected' : '' ?>>Quản trị viên</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-filter"></i> Lọc
                    </button>
                    <?php if(!empty($_GET['loc_role'])): ?>
                        <a href="index.php?page=users" class="btn btn-outline-secondary">
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
                                <form method="POST" action="index.php?page=users" style="display:inline-block;">
                                    <input type="hidden" name="delete_id" value="<?php echo $u['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</button>
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