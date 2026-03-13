<div class="container-fluid py-4" style="background-color: #f8f9fa;">
  <div class="container">
    <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8 pe-3">
        <h3 class="mb-4 fw-bold">Đơn hàng của tôi</h3>
        
        <!-- Products Section -->
        <div class="card border-0 shadow-sm p-4">
          <h5 class="mb-4 fw-bold">Sản phẩm</h5>
          
          <?php $tong = 0; ?>
          <?php foreach($o_items as $o): ?>
          <div class="row align-items-center mb-4 pb-4 border-bottom">
          <!-- print_r($o); -->
            <!-- Product Image -->
            <div class="col-auto">
              <?php if(!empty($o['image_url'])): ?>
                <img src="<?php echo $o['image_url']; ?>" alt="<?php echo $o['product_name']; ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
              <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 100px; height: 100px;"">
                  <span class="text-muted small">Không có ảnh</span>
                </div>
              <?php endif; ?>
            </div>
            
            <!-- Product Details -->
            <div class="col">
              <h6 class="mb-2 fw-bold"><?php echo $o['product_name'] ? $o['product_name'] : 'Sản phẩm bị xoá'; ?></h6>
              <small class="text-muted d-block mb-2">Loại: <span class="text-dark text-uppercase"><?php echo $o['category_name'] ? $o['category_name'] : 'N/A'; ?></span></small>
              <small class="text-muted d-block">Size: <span class="text-dark"><?php echo $o['size'] ? $o['size'] : 'N/A'; ?></span> | Màu: <span class="text-dark"><?php echo $o['color'] ? $o['color'] : 'N/A'; ?></span></small>
                
            </div>
            
            <!-- Quantity and Price -->
            <div class="col-auto text-end">
              <p class="mb-1 text-muted small">x<?php echo $o['quantity']; ?></p>
              <p class="mb-0 fw-bold text-dark"><?php echo number_format($o['price'], 0, ',', '.'); ?> đ</p>
            </div>
          </div>
          <?php $tong += $o['price'] * $o['quantity']; ?>
          <?php endforeach; ?>
          
          <!-- Summary -->
          <div class="mt-4">
            <div class="row mb-3 pb-3 border-bottom">
              <div class="col text-end">
                <small class="text-muted">Tạm tính</small>
              </div>
              <div class="col-auto text-end">
                <strong><?php echo number_format($tong, 0, ',', '.'); ?> đ</strong>
              </div>
            </div>
            
            <div class="row mb-3">
              <div class="col text-end">
                <small class="text-muted">Phí vận chuyển</small>
              </div>
              <div class="col-auto text-end">
                <strong class="text-success">+30.000 đ</strong>
              </div>
            </div>
            
            <div class="row pt-3 border-top">
              <div class="col text-end">
                <h6 class="fw-bold">Tổng cộng</h6>
              </div>
              <div class="col-auto text-end">
                <h5 class="fw-bold text-primary"><?php echo number_format($tong + 30000, 0, ',', '.'); ?> đ</h5>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4 ps-3">
        <div class="card border-0 shadow-sm p-4 h-100">
          <h5 class="mb-4 fw-bold">Chi tiết đơn hàng</h5>
          <!-- <pre><php print_r($order) ?></pre> -->
          
          <div class="mb-4">
            <small class="text-muted d-block mb-1">MÃ ĐƠN HÀNG</small>
            <h6 class="fw-bold">ORD-<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></h6>
          </div>
          
          <div class="mb-4 pb-4 border-bottom">
            <div class="row mb-3">
              <div class="col">
                <small class="text-muted d-block mb-1">NGÀY ĐẶT</small>
                <p class="mb-0 small"><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></p>
              </div>
              <div class="col-auto text-end">
                <small class="text-muted d-block mb-1">THANH TOÁN</small>
                <p class="mb-0 small"><?php echo $order['payment_method']; ?></p>
              </div>
            </div>
            <div class="d-flex gap-2">
              <span class="badge bg-success">
                <?php 
                  $status_text = [
                    'pending' => 'Chờ xác nhận',
                    'confirmed' => 'Đang xử lý',
                    'shipping' => 'Đang giao hàng',
                    'delivered' => 'Đã giao',
                    'cancelled' => 'Đã hủy'
                  ];
                  echo $status_text[$order['status']] ?? $order['status'];
                ?>
              </span>
            </div>
          </div>
          
          <div class="mb-4 pb-4 border-bottom">
            <small class="text-muted d-block mb-2">ĐỊA CHỈ GIAO HÀNG</small>
            <p class="small mb-0"><?php echo $_SESSION['user']['address']; ?></p>
          </div>
          
          <div>
            <small class="text-muted d-block mb-2">KHÁCH HÀNG</small>
            <p class="small mb-0 fw-bold"><?php echo $_SESSION['user']['full_name']; ?></p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Back Button -->
    <div class="mt-4">
      <a href="index.php?page=orders" class="btn btn-outline-secondary">Quay lại danh sách đơn hàng</a>
    </div>
  </div>
</div>