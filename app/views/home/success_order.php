<?php
if (!isset($_SESSION['order_success'])) {
    header("Location: index.php?page=home");
    exit;
}

$o = $_SESSION['order_success'];

unset($_SESSION['order_success']);
?>
<div class="card shadow p-4">
    <div class="text-center mb-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="green" class="bi bi-check-circle-fill mb-2" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.08.022l3.992-4.183a.75.75 0 1 0-1.08-1.04L7.5 9.477 5.02 7.017a.75.75 0 0 0-1.04 1.08l3 2.933z"/>
      </svg>
      <h4 class="text-success fw-bold">Đặt hàng thành công!</h4>
      <p class="text-muted">Cảm ơn bạn đã mua sắm cùng chúng tôi.<br>Đơn hàng của bạn đang được xử lý.</p>
    </div>

    <!-- Thông tin đơn hàng -->
    <div class="border-top pt-3">
      <h6 class="fw-bold mb-3">Thông tin đơn hàng</h6>
      <div class="row mb-2">
        <div class="col-5 text-muted">Mã đơn hàng:</div>
        <div class="col-7 fw-semibold">#<?php echo $o['id'] ?></div>
      </div>
      <div class="row mb-2">
        <div class="col-5 text-muted">Khách hàng:</div>
        <div class="col-7"><?php echo $o['name'] ?></div>
      </div>
      <div class="row mb-2">
        <div class="col-5 text-muted">Tổng tiền:</div>
        <div class="col-7 text-danger fw-semibold"><?php echo $o['total'] ?></div>
      </div>
      <div class="row mb-2">
        <div class="col-5 text-muted">Thanh toán:</div>
        <div class="col-7"><?php echo $o['payment']; ?></div>
      </div>
      <div class="row mb-2">
        <div class="col-5 text-muted">Địa chỉ giao:</div>
        <div class="col-7"><?php echo $o['address'] ?></div>
      </div>
      <div class="row mb-2">
        <div class="col-5 text-muted">Ngày đặt:</div>
        <div class="col-7"><?php echo $o['created_at'] ?></div>
      </div>
    </div>

    <!-- Nút hành động -->
    <div class="mt-4 d-grid gap-2">
      <a href="index.php?page=home" class="btn btn-success">Quay lại trang chủ</a>
      <a href="index.php?page=orders&id=<?php echo $o['id']; ?>" class="btn btn-outline-success">Xem chi tiết đơn hàng</a>
    </div>
  </div>