<div class="container py-5">
    <div class="row g-4">

        <!-- Ảnh sản phẩm -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <img src="<?php echo $products['main_image']; ?>" class="card-img-top" width="350" height="350" alt="Main image">
                <div class="card-body">
                    <div class="d-flex justify-content-center gap-2">
                        <?php foreach($products['list_images'] as $i): ?>
                        <img src="<?php echo $i['image_url']; ?>" class="img-thumbnail" width="150" height="150" alt="Ảnh phụ">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <span class="badge bg-secondary mb-2">Danh mục: <span id="category_name"><?php echo $products['category_name']; ?></span></span>
                <h3 id="name" class="mb-3"><?php echo $products['name']; ?></h3>
                <p id="description" class="text-muted"><?php echo $products['description']; ?></p>

                <h4 class="text-danger mb-3">
                    Giá: <span id="price"><?php echo number_format($products['price'], 0, ',', '.'); ?> vnđ</span>
                </h4>

                <!-- Màu sắc -->
                <div class="mb-3">
                    <h6 class="fw-bold">Màu sắc:</h6>
                    <div class="d-flex gap-2">
                        <?php foreach($products['colors'] as $c): ?>
                        <button class="btn btn-outline-dark btn-sm"><?php echo $c; ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Kích thước -->
                <div class="mb-3">
                    <h6 class="fw-bold">Kích thước:</h6>
                    <div class="d-flex gap-2">
                        <?php foreach($products['sizes'] as $s): ?>
                        <button class="btn btn-outline-primary btn-sm"><?php echo $s; ?></button>
                        <?php endforeach; ?>
                    </div>
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
            </div>
        </div>

    </div>
</div>