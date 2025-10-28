<section class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Sửa sản phẩm</h4>
    </div>
    <div class="card-body">
      <?php $p = $product[0]; ?>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" value="<?php echo $p['id']; ?>">

        <!-- Danh mục -->
        <div class="mb-3">
          <label class="form-label">Danh mục</label>
          <select class="form-select" name="category_id" required>
            <?php foreach ($categorys as $c): ?>
              <option value="<?= $c['id'] ?>" <?= $c['id'] == $p['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Tên -->
        <div class="mb-3">
          <label class="form-label">Tên sản phẩm</label>
          <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($p['name']) ?>" required>
        </div>

        <!-- Mô tả -->
        <div class="mb-3">
          <label class="form-label">Mô tả</label>
          <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($p['description']) ?></textarea>
        </div>

        <!-- Giá -->
        <div class="mb-3">
          <label class="form-label">Giá (VNĐ)</label>
          <input type="number" class="form-control" name="price" value="<?= htmlspecialchars($p['price']) ?>" min="0" step="1" required>
        </div>

        <!-- Trạng thái -->
        <div class="mb-3">
          <label class="form-label">Trạng thái</label>
          <select class="form-select" name="status" required>
            <option value="active" <?= $p['status'] == 'active' ? 'selected' : '' ?>>Hiển thị</option>
            <option value="hide" <?= $p['status'] == 'hide' ? 'selected' : '' ?>>Ẩn</option>
          </select>
        </div>

        <!-- Ảnh sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Ảnh sản phẩm (jpg, jpeg, png, gif)</label>
          <div class="d-flex flex-wrap gap-2">
            <?php foreach ($images as $img): ?>
              <div class="border p-2 text-center">
                <img src="../<?= $img['image_url'] ?>" style="width:100px; height:100px; object-fit:cover;">

                <div class="form-check">
                  <input type="checkbox" name="delete_image_ids[]" value="<?= $img['id'] ?>">
                  <label>Xóa</label>
                </div>

                <div class="form-check">
                  <input type="radio" name="primary_image" value="<?= $img['id'] ?>"
                    <?= $img['is_primary'] == 1 ? 'checked' : '' ?>>
                  <label>Ảnh chính</label>
                </div>
              </div>

            <?php endforeach; ?>
          </div>
          <input type="file" name="images[]" multiple class="form-control mt-2">
        </div>

        <!-- Thuộc tính sản phẩm -->
        <div class="mb-3">
          <label class="form-label">Thuộc tính (Màu, Size, Số lượng)</label>
          <div id="variant-container">
            <?php foreach ($variants as $v): ?>
              <div class="row g-2 mb-2 align-items-center">
                <input type="hidden" name="variant_id[]" value="<?= $v['id'] ?>">
                <div class="col-md-3"><input type="text" class="form-control" name="variant_color[]" value="<?= htmlspecialchars($v['color']) ?>" placeholder="Màu sắc"></div>
                <div class="col-md-3"><input type="text" class="form-control" name="variant_size[]" value="<?= htmlspecialchars($v['size']) ?>" placeholder="Size"></div>
                <div class="col-md-3"><input type="number" class="form-control" name="variant_stock[]" value="<?= htmlspecialchars($v['stock']) ?>" placeholder="Tồn kho"></div>
                <div class="col-md-2 text-center">
                  <input type="checkbox" name="delete_variant_ids[]" value="<?= $v['id'] ?>"> Xóa
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <button type="button" id="add-variant" class="btn btn-outline-secondary btn-sm mt-2">+ Thêm thuộc tính</button>
        </div>

        <button type="submit" class="btn btn-success w-100">Lưu sản phẩm</button>
      </form>
      <a href="index.php?page=products" class="btn btn-danger w-100 mt-2">Quay lại</a>
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