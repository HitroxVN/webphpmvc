<!-- Login Form -->
<main class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm rounded-4">
        <div class="card-body p-4">
          <h2 class="card-title text-center mb-4">Đăng nhập</h2>
          <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $err) : ?>
                  <li><?php echo $err; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php elseif(!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
              <?php
              echo $_SESSION['success'];
              unset($_SESSION['success']);
              ?>
            </div>
          <?php endif; ?>
          <form id="login-form" method="post">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input name="email" type="email" class="form-control" id="email" placeholder="Nhập email" value="<?php echo ($email ?? ''); ?>" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mật khẩu</label>
              <input name="password" type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Đăng nhập</button>
          </form>
          <p class="mt-3 text-center">Chưa có tài khoản? <a href="index.php?page=register">Đăng ký</a></p>
        </div>
      </div>
    </div>
  </div>
</main>