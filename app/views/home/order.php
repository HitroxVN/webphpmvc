<div class="container py-5">
  <h2 class="mb-4 text-center">Đơn hàng của bạn</h2>

  <table class="table table-bordered table-hover text-center align-middle bg-white">
    <thead class="table-light">
      <tr>
        <th>Mã đơn hàng</th>
        <th>Ngày đặt</th>
        <th>Tổng tiền</th>
        <th>Thanh toán</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($order as $o): ?>
      <tr>
        <td><?php echo $o['id']; ?></td>
        <td><?php echo $o['created_at']; ?></td>
        <td><?php echo $o['total_amount']; ?></td>
        <td><?php echo $o['payment_method']; ?></td>
        <td><?php echo $o['status']; ?></td>
        <td><a href="index.php?page=orders&id=<?php echo $o['id']; ?>" class="btn btn-sm btn-dark">Xem chi tiết</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>