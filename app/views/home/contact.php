<?php
// contact.php
if (!isset($_GET['page']) || $_GET['page'] !== 'contact') {
    die('Trang không hợp lệ');
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .contact-container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .contact-info li i {
            color: #0d6efd;
        }

        .contact-info li {
            margin-bottom: 12px;
            font-size: 1.05rem;
        }

        .form-control {
            padding: 12px;
        }

        .btn-custom {
            padding: 12px 25px;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="contact-container">
        <h2 class="text-center mb-4">Liên hệ với chúng tôi</h2>
        <div class="row">

            <!-- Thông tin liên hệ -->
            <div class="col-md-5">
                <h4 class="mb-3">Thông tin liên hệ</h4>
                <ul class="list-unstyled contact-info">
                    <li><i class="bi bi-geo-alt-fill me-2"></i>205 Đ.Phú Diễn, P. Phú Diễn, TP. Hà Nội</li>
                    <li><i class="bi bi-telephone-fill me-2"></i>0123 456 789</li>
                    <li><i class="bi bi-envelope-fill me-2"></i>truong@gmail.com</li>
                    <li><i class="bi bi-clock-fill me-2"></i>8:00 - 21:00 (T2-CN)</li>
                    <li><a href="https://github.com/HitroxVN" class="text-decoration-none"><i class="bi bi-github me-2"></i>Hoang Truong (HitroxVN)</a></li>
                </ul>
            </div>

            <!-- Form liên hệ -->
            <div class="col-md-7">
                <h4 class="mb-3">Gửi tin nhắn</h4>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $e): ?>
                                <li><?php echo htmlspecialchars($e); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php elseif (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Cảm ơn bạn! Tin nhắn đã được gửi.</div>
                <?php endif; ?>

                <form action="index.php?page=contact" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tin nhắn</label>
                        <textarea name="message" class="form-control" rows="5" required><?php echo htmlspecialchars($old['message'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom">Gửi ngay</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>