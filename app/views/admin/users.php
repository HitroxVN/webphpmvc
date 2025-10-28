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
                            <td><?php echo $u['full_name']; ?></td>
                            <td><?php echo $u['email']; ?></td>
                            <td><?php echo $u['phone']; ?></td>
                            <td><?php echo $u['address']; ?></td>
                            <td><?php echo $u['role']; ?></td>
                            <td><?php echo $u['status']; ?></td>
                            <td>
                                <a href="index.php?page=user_edit&id=<?php echo $u['id']; ?>" class="btn btn-warning btn-sm me-1" style="display:inline-block;">Sửa</a>
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