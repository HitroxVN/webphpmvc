<section class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Thêm sản phẩm mới</h4>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <!-- Category -->
        <div class="mb-3">
          <label for="category_id" class="form-label">Danh mục</label>
          <select class="form-select" id="category_id" name="category_id" required>
            <?php foreach($categorys as $c): ?>
                <option value="<?php echo $c['id'];?>"><?php echo $c['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Name -->
        <div class="mb-3">
          <label for="name" class="form-label">Tên sản phẩm</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
          <label for="description" class="form-label">Mô tả</label>
          <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả sản phẩm" required></textarea>
        </div>

        <!-- Price -->
        <div class="mb-3">
          <label for="price" class="form-label">Giá (VNĐ)</label>
          <input type="number" class="form-control" id="price" name="price" placeholder="Nhập giá sản phẩm" step="0.01" min="0" required>
        </div>

        <!-- Trạng thái -->
        <div class="mb-3">
          <label class="form-label">Trạng thái</label>
          <select class="form-select" name="status" required>
            <option value="active" selected>Hiển thị</option>
            <option value="hide">Ẩn</option>
          </select>
        </div>

        <!-- Ảnh sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Ảnh chính sản phẩm (jpg, jpeg, png, gif)</label>
          <input type="file" name="main_image" class="form-control mt-2" required>
        </div>

        <!-- Ảnh phụ sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Ảnh phụ sản phẩm (jpg, jpeg, png, gif)</label>
          <input type="file" name="images[]" multiple class="form-control mt-2" required>
        </div>

        <!-- Thuộc tính sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Thuộc tính (Màu, Size, Số lượng)</label>
          <div id="variant-container">
              <div class="row g-2 mb-2 align-items-center">
                <input type="hidden" name="variant_id[]" value="<?= $v['id'] ?>">
                <div class="col-md-3"><input type="text" class="form-control" name="variant_color[]" placeholder="Màu sắc"></div>
                <div class="col-md-3"><input type="text" class="form-control" name="variant_size[]" placeholder="Size"></div>
                <div class="col-md-3"><input type="number" class="form-control" name="variant_stock[]" placeholder="Tồn kho"></div>
              </div>
          </div>
          <button type="button" id="add-variant" class="btn btn-outline-secondary btn-sm mt-2">+ Thêm thuộc tính</button>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-success w-100">Lưu sản phẩm</button>
      </form>
      <a href="index.php?page=products" class="btn btn-danger w-100">Quay lại</a>
    </div>
  </div>
</section>

<script>
  document.getElementById('add-variant').addEventListener('click', () => {
    const container = document.getElementById('variant-container');
    const div = document.createElement('div');
    div.className = 'row g-2 mb-2 align-items-center';
    div.innerHTML = `
    <input type="hidden" name="variant_id[]" value="">
    <div class="col-md-3"><input type="text" class="form-control" name="variant_color[]" placeholder="Màu sắc"></div>
    <div class="col-md-3"><input type="text" class="form-control" name="variant_size[]" placeholder="Size"></div>
    <div class="col-md-3"><input type="number" class="form-control" name="variant_stock[]" placeholder="Tồn kho"></div>
  `;
    container.appendChild(div);
  });
</script>