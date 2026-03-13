<div class="container py-5">
  <h2 class="mb-4 text-center">Đơn hàng của bạn</h2>

  <!-- Search Bar -->
  <!-- <div class="mb-4">
    <input type="text" class="form-control" placeholder="Tìm đơn hàng theo tên sản phẩm hoặc mã đơn...">
  </div> -->

  <!-- Filter Tabs -->
  <!-- <div class="mb-4">
    <nav class="nav nav-underline gap-3 border-bottom">
      <a class="nav-link active text-dark fw-medium" href="#">Tất cả đơn</a>
      <a class="nav-link text-secondary" href="#">Đang xử lý</a>
      <a class="nav-link text-secondary" href="#">Đang giao hàng</a>
      <a class="nav-link text-secondary" href="#">Đã giao</a>
      <a class="nav-link text-secondary" href="#">Đã hủy</a>
      <a class="nav-link text-secondary" href="#">Trả hàng</a>
    </nav>
  </div> -->

  <!-- Order Cards -->
  <div class="space-y-3">
    <?php foreach($order as $o): ?>
    <div class="card border-0 shadow-sm mb-3">
      <!-- Card Header -->
      <div class="card-header bg-white border-bottom ps-4 pe-4 pt-3 pb-3">
        <div class="row align-items-center">
          <div class="col">
            <small class="text-muted">ORD-<?php echo str_pad($o['id'], 5, '0', STR_PAD_LEFT); ?></small>
            <span class="text-muted mx-2">|</span>
            <small class="text-muted"><?php echo date('d/m/Y', strtotime($o['created_at'])); ?></small>
          </div>
          <div class="col-auto">
            <span class="badge bg-success">
              <?php 
                $status_text = [
                  'pending' => 'Chờ xác nhận',
                  'confirmed' => 'Đang xử lý',
                  'shipping' => 'Đang giao hàng',
                  'delivered' => 'Đã giao',
                  'cancelled' => 'Đã hủy'
                ];
                echo $status_text[$o['status']] ?? $o['status'];
              ?>
            </span>
          </div>
        </div>
      </div>

      <!-- Card Body -->
      <div class="card-body p-4">
        <div class="row align-items-center">
          <!-- Product Image -->
          <div class="col-auto">
            <img src="<?php echo $o['main_image'] ?? 'uploads/no-image.png'; ?>" alt="Sản phẩm" style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px;">
          </div>

          <!-- Product Info -->
          <div class="col">
            <h6 class="mb-2 fw-bold"><?php echo $o['product_name'] ?? 'Sản phẩm'; ?></h6>
            <small class="text-muted d-block">Số lượng: <span class="text-dark"><?php echo $o['quantity'] ?? '1'; ?></span></small>
            <h6 class="mt-2 text-primary fw-bold"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?> đ</h6>
          </div>

          <!-- View Details Link -->
          <div class="col-auto text-end">
            <a href="index.php?page=orders&id=<?php echo $o['id']; ?>" class="text-primary text-decoration-none fw-medium">Xem chi tiết →</a>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Pagination -->
  <?php if($total_pages > 1): ?>
  <nav class="mt-5" aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <!-- Previous Button -->
      <li class="page-item <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
        <a class="page-link" href="index.php?page=orders&pagination=<?php echo $current_page - 1; ?>"> Trước</a>
      </li>

      <!-- Page Numbers -->
      <?php 
        $start_page = max(1, $current_page - 2);
        $end_page = min($total_pages, $current_page + 2);
        
        if($start_page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="index.php?page=orders&pagination=1">1</a>
          </li>
          <?php if($start_page > 2): ?>
            <li class="page-item disabled">
              <span class="page-link">...</span>
            </li>
          <?php endif; ?>
        <?php endif; ?>

        <?php for($i = $start_page; $i <= $end_page; $i++): ?>
          <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
            <a class="page-link" href="index.php?page=orders&pagination=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>

        <?php if($end_page < $total_pages): ?>
          <?php if($end_page < $total_pages - 1): ?>
            <li class="page-item disabled">
              <span class="page-link">...</span>
            </li>
          <?php endif; ?>
          <li class="page-item">
            <a class="page-link" href="index.php?page=orders&pagination=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
          </li>
        <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?php echo $current_page == $total_pages ? 'disabled' : ''; ?>">
        <a class="page-link" href="index.php?page=orders&pagination=<?php echo $current_page + 1; ?>">Tiếp </a>
      </li>
    </ul>
  </nav>
  <?php endif; ?>
</div>