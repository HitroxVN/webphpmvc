<!-- Products Section -->
<section class="py-5 bg-white" id="product-list">
  <div class="container">
    <!-- title -->
    <div class="text-center mb-5">
      <h2 class="fw-bold">Danh sách sản phẩm</h2>
      <p class="text-muted">Khám phá các mẫu giày mới nhất và phong cách nhất của chúng tôi</p>
    </div>

    <!-- list sản phẩm -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $p): ?>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <img src="<?=
                        !empty($p['main_image']) && file_exists($p['main_image'])
                          ? $p['main_image']
                          : (file_exists('uploads/no-image.png')
                            ? 'uploads/no-image.png'
                            : 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png'
                          )
                        ?>" class="card-img-top border border-2 border-secondary" width="200" height="200">
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo $p['name']; ?></h5>
                <p class="text-primary fw-bold mb-3"><?php echo number_format($p['price'], 0, ',', '.'); ?> vnđ</p>
                <a href="index.php?page=products&id=<?php echo $p['id']; ?>" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>
</section>