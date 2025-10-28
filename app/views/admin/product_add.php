<section class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Thêm sản phẩm mới</h4>
    </div>
    <div class="card-body">
      <form method="post">
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
          <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả sản phẩm"></textarea>
        </div>

        <!-- Price -->
        <div class="mb-3">
          <label for="price" class="form-label">Giá (VNĐ)</label>
          <input type="number" class="form-control" id="price" name="price" placeholder="Nhập giá sản phẩm" step="0.01" min="0" required>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-success w-100">Lưu sản phẩm</button>
      </form>
      <a href="index.php?page=products" class="btn btn-danger w-100">Quay lại</a>
    </div>
  </div>
</section>
