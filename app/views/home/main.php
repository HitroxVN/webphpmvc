<main>
  <!-- Hero Section -->
  <!-- <section class="hero bg-body-secondary py-5">
    <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-between">
      <div class="mb-4 mb-lg-0">
        <h1 class="display-5 fw-bold">Giày thời trang — Phong cách của bạn</h1>
        <p class="lead">Chọn đôi giày hoàn hảo — thoải mái, bền, và đẹp.</p>
        <a class="btn btn-dark btn-lg" href="index.php?page=products">Mua ngay</a>
      </div>
      <img src="https://conndesign.vn/wp-content/uploads/2023/07/Thiet-ke-shop-giay-1.png" alt="hero" class="img-fluid rounded shadow w-25">
    </div>
  </section> -->

  <div class="position-relative" style="height:100vh; overflow:hidden;">
    <video autoplay muted loop style="position:absolute; width:100%; height:100%; object-fit:cover;">
      <source src="/WEBPHPMVC/public/assets/shoes.mp4" type="video/mp4">
    </video>
    <div class="position-absolute w-100 h-100" style="background:rgba(0,0,0,0.45);"></div>
    <div class="position-absolute top-50 start-50 translate-middle text-white" style="z-index:3; width:100%; padding:0 50px;">
      <h1 class="fw-bold" style="font-size:3rem; line-height:1.2;">
        Giày thời trang — Phong cách của bạn
      </h1>
      <p class="mt-3" style="font-size:1.3rem; opacity:0.9;">
        Chọn đôi giày hoàn hảo — thoải mái, bền và đẹp.
      </p>
      <a href="index.php?page=products" class="btn btn-outline-warning btn-lg px-4 mt-3">
        Mua ngay
      </a>
    </div>

  </div>


  <!-- new Products Section -->
  <section class="featured py-5 bg-white" id="spnew">
    <div class="container">
      <h2 class="text-center mb-5">Sản phẩm mới nhất</h2>
      <div id="featured-list" class="row g-4 justify-content-center">
        <?php if (!empty($newProducts)): ?>
          <?php foreach ($newProducts as $p): ?>
            <div class="col-6 col-md-3">
              <div class="card h-100 shadow-sm">
                <div class="img-wrap">
                  <img src="<?=
                            !empty($p['main_image']) && file_exists($p['main_image'])
                              ? $p['main_image']
                              : (file_exists('uploads/no-image.png')
                                ? 'uploads/no-image.png'
                                : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png'
                              )
                            ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>">
                </div>
                <div class="card-body text-center">
                  <h5 class="card-title"><?= $p['name']; ?></h5>
                  <p class="card-text text-dark fw-bold"><?= number_format($p['price'], 0, ',', '.'); ?> vnđ</p>
                  <a href="index.php?page=products&id=<?php echo $p['id']; ?>" class="btn btn-outline-dark btn-sm">Xem chi tiết</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </div>
  </section>

  <!-- Info Cards Section -->
  <section class="info-cards py-5 bg-body-secondary">
    <div class="container">
      <div class="row text-center g-4">
        <div class="col-md-4">
          <div class="card p-4 shadow-sm h-100">
            <i class="bi bi-truck display-4 mb-3 text-dark"></i>
            <h5>Miễn phí giao hàng</h5>
            <p>Cho đơn hàng trên 1.000.000₫</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-4 shadow-sm h-100">
            <i class="bi bi-award display-4 mb-3 text-dark"></i>
            <h5>Bảo hành 30 ngày</h5>
            <p>Đảm bảo sản phẩm chất lượng</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-4 shadow-sm h-100">
            <i class="bi bi-arrow-repeat display-4 mb-3 text-dark"></i>
            <h5>Hỗ trợ đổi trả</h5>
            <p>Đổi trả dễ dàng trong 7 ngày</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-5 bg-white">
    <div class="container">
      <h2 class="text-center mb-4">About 4TC Shop</h2>
      <p class="text-center mb-4 lead">4TC Shop là cửa hàng giày thời trang uy tín, cung cấp những sản phẩm chất lượng, thoải mái và hợp thời trang. Chúng tôi cam kết mang đến trải nghiệm mua sắm tuyệt vời cho khách hàng.</p>
      <div class="text-center">
        <a href="index.php?page=contact" class="btn btn-dark btn-lg">Liên hệ ngay</a>
      </div>
    </div>
  </section>
</main>