<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-secondary text-white text-center">
          <h4 class="mb-0">Thông tin tài khoản</h4>
        </div>

        <div class="card-body p-4">
          <p class="mb-4 text-center">Xin chào, <strong><?= htmlspecialchars($user['full_name']) ?></strong></p>

          <form method="post">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <?php if (!empty($notify)): ?>
              <?php foreach ($notify as $type => $msg): ?>
                <?php
                $alertClass = ($type === 'ok') ? 'success' : 'danger';
                ?>
                <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show" role="alert">
                  <?= htmlspecialchars($msg) ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>

            <div class="mb-3">
              <label class="form-label">Họ tên</label>
              <input type="text" name="full_name" class="form-control"
                value="<?= htmlspecialchars($user['full_name']) ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Địa chỉ</label>
              <input type="text" name="address" class="form-control"
                value="<?= htmlspecialchars($user['address'] ?? '') ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Số điện thoại</label>
              <input type="text" name="phone" class="form-control"
                value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control"
                value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-dark">Cập nhật</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>