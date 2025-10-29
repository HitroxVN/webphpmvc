<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập trang admin</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-sm w-100" style="max-width: 400px;">
        <div class="card-body p-4">
            <h3 class="card-title text-center mb-4">Đăng nhập Admin Panel</h3>
          <?php
          if (!empty($errors)) : ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $err) : ?>
                  <li><?php echo $err; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="admin@example.com" value="<?php echo $email ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
                </div>
                <!-- <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                </div> -->
                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            </form>
            <!-- <div class="mt-3 text-center">
                <a href="#">Quên mật khẩu?</a>
            </div> -->
        </div>
    </div>
</div>
</body>
</html>