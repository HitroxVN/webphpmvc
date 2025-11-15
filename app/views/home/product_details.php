<div class="container py-5">
    <div class="row g-4">

        <!-- Ảnh sản phẩm -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="img-wrap-main">
                    <img id="mainImage" src="<?php echo $products['main_image']; ?>" class="card-img-top" alt="Main image" style="cursor: pointer;">
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <?php foreach ($products['list_images'] as $i): ?>
                            <img src="<?php echo $i['image_url']; ?>" class="img-thumbnail thumbnail-img" width="100" height="100" alt="Ảnh phụ" style="cursor: pointer; transition: opacity 0.2s;" data-full-src="<?php echo $i['image_url']; ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <span class="badge bg-secondary mb-2">Danh mục: <span id="category_name"><?php echo $products['category_name'] ?? 'Không có danh mục'; ?></span></span>
                <h3 id="name" class="mb-3"><?php echo $products['name']; ?></h3>
                <p id="description" class="text-muted"><?php echo $products['description']; ?></p>

                <h4 class="text-danger mb-3">
                    Giá: <span id="price"><?php echo number_format($products['price'], 0, ',', '.'); ?> vnđ</span>
                </h4>
                <form action="index.php?page=cart" method="post">

                    <!-- Màu & Size -->
                    <div class="mb-4">

                        <?php if (!empty($products['sizeGroups'])): ?>
                            <?php foreach ($products['sizeGroups'] as $size => $colors): ?>
                                    <!-- Hiển thị size -->
                                    <label class="fw-bold text-dark d-block mb-2">
                                        Size: <?php echo $size; ?>
                                    </label>
                                    <!-- Danh sách màu tương ứng -->
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach ($colors as $c): ?>
                                            <label class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                <input type="radio" name="add_cart" value="<?php echo $c['variant_id']; ?>" class="me-2" required>
                                                Màu <?php echo $c['color']; ?>
                                                (<?php echo $c['stock']; ?>)
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Chưa có màu/size cho sản phẩm này.</p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Số lượng:</label>
                        <input type="number" name="quantity" class="form-control" min="1" max="<?php echo $products['stock']; ?>" value="1" required style="max-width: 60px;">
                    </div>

                    <!-- Tồn kho -->
                    <p class="mt-3">
                        <strong>Tồn kho:</strong> <span id="stock"><?php echo $products['stock']; ?></span> sản phẩm
                    </p>

                    <!-- Nút mua -->
                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-success flex-fill">Thêm vào giỏ</button>
                        <button class="btn btn-danger flex-fill">Mua ngay</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

    <?php include_once __DIR__ . '/previewImage.php'; ?>