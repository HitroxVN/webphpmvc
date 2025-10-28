<!-- Register Form -->
<main class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm rounded-4">
        <div class="card-body p-4">
          <h2 class="card-title text-center mb-4">Đăng ký tài khoản</h2>
          <?php
          if (!empty($errors)) : ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $err) : ?>
                  <li><?php echo $err;?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <form id="register-form" method="post">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input name="email" type="email" class="form-control" id="email" placeholder="Nhập email" value="<?php echo($email ?? '') ?>" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Mật khẩu</label>
              <input name="password" type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="mb-3">
              <label for="repassword" class="form-label">Nhập lại mật khẩu</label>
              <input name="repassword" type="password" class="form-control" id="repassword" placeholder="Nhập lại mật khẩu" required>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Đăng ký</button>
          </form>
          <p class="mt-3 text-center">Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>
        </div>
      </div>
    </div>
  </div>
</main>