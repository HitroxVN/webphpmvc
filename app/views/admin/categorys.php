<section id="categorys">
    <h2 class="mb-3">Quản lý Danh mục</h2>

    <?php if(!empty($thongbao)): ?>
        <?php echo $thongbao ?>
    <?php endif; ?>

    <!-- Form thêm -->
    <div class="card mb-4 shadow-sm border-primary">
        <div class="card-body">
            <form method="POST" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label class="fw-bold"><i class="bi bi-tag me-1"></i> Thêm danh mục mới:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="add_name" class="form-control" placeholder="Nhập tên danh mục..." required>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary px-4">
                        <i class="bi bi-plus-lg"></i> Thêm ngay
                    </button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Trạng thái</th>
                <th width="150">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($categorys)): ?>
                <?php foreach ($categorys as $cate): ?>
                    <tr>
                        <form method="POST">
                            <td>
                                <?php echo $cate['id']; ?>
                                <input type="hidden" name="id" value="<?php echo $cate['id']; ?>">
                            </td>
                            <td>
                                <input type="text" name="name" value="<?php echo $cate['name']; ?>" class="form-control form-control-sm" required>
                            </td>
                            <td>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="active" <?= $cate['status'] == 'active' ? 'selected':'' ?>>Hiển thị</option>
                                    <option value="hide" <?= $cate['status'] == 'hide' ? 'selected':'' ?>>Ẩn</option>
                                </select>
                            </td>
                            <td class="d-flex gap-1 justify-content-center">
                                <button type="submit" name="capnhap" class="btn btn-success btn-sm">Cập nhật</button>
                                <button type="submit" name="xoa" class="btn btn-danger btn-sm" onclick="return confirm('Xóa danh mục này?')">Xóa</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-muted">Không có danh mục nào</td></tr>
            <?php endif; ?>
        </tbody>

    </table>
</section>
