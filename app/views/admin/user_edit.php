<section class="container">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Sửa người dùng</h4>
    </div>
    <div class="card-body">
      <?php $p = $user; ?>
      <form method="post">
        <input type="hidden" name="edit_id" value="<?php echo $p['id']; ?>">

        <!-- Tên -->
        <div class="mb-3">
          <label class="form-label">Tên người dùng</label>
          <input type="text" class="form-control" name="full_name" value="<?php echo ($p['full_name']) ?>" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" value="<?php echo ($p['email']) ?>" required>
        </div>

        <!-- sdt -->
        <div class="mb-3">
          <label class="form-label">Số điện thoại</label>
          <input type="tel" class="form-control" name="phone" value="<?php echo ($p['phone']) ?>" required>
        </div>

        <!-- Địa chỉ -->
         <div class="mb-3">
          <label class="form-label">Địa chỉ</label>
          <textarea class="form-control" name="address" rows="3"><?php echo ($p['address']) ?></textarea>
        </div>

        <!-- vai trò -->
        <div class="mb-3">
          <label class="form-label">Vai trò</label>
          <select class="form-select" name="role" required>
            <option value="customer" <?= $p['role'] == 'customer' ? 'selected' : '' ?>>Khách hàng</option>
            <option value="admin" <?= $p['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
          </select>
        </div>

        <!-- Trạng thái -->
        <div class="mb-3">
          <label class="form-label">Trạng thái</label>
          <select class="form-select" name="status" required>
            <option value="active" <?= $p['status'] == 'active' ? 'selected' : '' ?>>Hoạt động</option>
            <option value="banned" <?= $p['status'] == 'banned' ? 'selected' : '' ?>>Bị cấm</option>
          </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Lưu người dùng</button>
      </form>
      <a href="index.php?page=users" class="btn btn-danger w-100 mt-2">Quay lại</a>
    </div>
  </div>
</section>