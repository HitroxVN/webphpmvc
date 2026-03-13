<div class="container py-5">
  <h2 class="mb-4 text-center">Chi tiết đơn hàng #<?php echo $order['id']; ?></h2>

  <div class="card p-4 mb-4">
    <h5 class="mb-3">Thông tin khách hàng</h5>
    <div class="row mb-2">
      <div class="col-4 text-muted">Khách hàng:</div>
      <div class="col-8"><?php echo $_SESSION['user']['full_name']; ?></div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-muted">Địa chỉ:</div>
      <div class="col-8"><?php echo $_SESSION['user']['address']; ?></div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-muted">Thanh toán:</div>
      <div class="col-8"><?php echo $order['payment_method']; ?></div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-muted">Ngày đặt:</div>
      <div class="col-8"><?php echo $order['created_at']; ?></div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-muted">Trang thái:</div>
      <div class="col-8"><?php echo $order['status']; ?></div>
    </div>
  </div>

  <div class="card p-4">
    <h5 class="mb-3">Sản phẩm trong đơn hàng</h5>
    <?php $tong = 0; ?>
    <table class="table table-bordered table-hover">
      <thead class="table-light">
        <tr>
          <th>Sản phẩm</th>
          <th>Size</th>
          <th>Màu</th>
          <th>Số lượng</th>
          <th>Giá</th>
          <th>Tổng</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($o_items as $o): ?>
          <tr>
            <td><?php echo $o['product_name'] ? $o['product_name'] : 'Sản phẩm bị xoá'; ?></td>
            <td><?php echo $o['size'] ? $o['size'] : 'Sản phẩm bị xoá'; ?></td>
            <td><?php echo $o['color'] ? $o['size'] : 'Sản phẩm bị xoá'; ?></td>
            <td><?php echo $o['quantity']; ?></td>
            <td><?php echo number_format($o['price'], 0, ',', '.'); ?> vnđ</td>
            <td>
              <?php echo number_format($o['price'] * $o['quantity'], 0, ',', '.');
              $tong += $o['price'] * $o['quantity']; ?>
              vnđ
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" class="text-end fw-bold">Tổng thanh toán:</td>
          <td class="text-danger fw-bold"><?php echo number_format($tong, 0, ',', '.'); ?> vnđ</td>
        </tr>
      </tfoot>
    </table>

    <div class="mt-3">
      <a href="index.php?page=orders" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
      <?php if ($order['status'] == 'pending'): ?>
        <form action="index.php?page=orders" method="post" style="display:inline-block;"
          onsubmit="return confirm('Bạn có chắc chắn muốn huỷ đơn này?');">
          <input type="hidden" name="action" value="cancel">
          <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
          <?php if ($order['payment_method'] == 'BANKING'): ?>
            <button type="button" class="btn btn-success ms-2"
              onclick="window.location.href='index.php?page=payment&id=<?php echo $order['id']; ?>'">Tiếp tục thanh
              toán</button>
          <?php endif; ?>
          <button type="submit" class="btn btn-danger ms-2">Huỷ đơn</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>