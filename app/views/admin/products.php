<section id="products">
    <h2 class="mb-3">Quản lý Sản phẩm</h2>
    <?php if (!empty($thongbao)): ?>
        <?php echo $thongbao ?>
    <?php endif; ?>
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <a href="index.php?page=products&action=add" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Thêm sản phẩm mới
            </a>
        </div>
        <div class="col-md-6">
            <form action="index.php" method="get">
                <input type="hidden" name="page" value="products">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm, danh mục..." value="<?php echo $_GET['search'] ?? ''; ?>">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                    <?php if(!empty($_GET['search'])): ?>
                        <a href="index.php?page=products" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Danh mục</th>
                <th>Tên sản phẩm</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?php echo $p['id']; ?></td>
                        <td><?php echo $p['category_name'] ?? '<span class="text-danger">Danh mục bị xoá</span>'; ?></td>
                        <td><?php echo $p['name']; ?></td>
                        <td><?php echo $p['description']; ?></td>
                        <td><?php echo number_format($p['price'], 0, ',', '.'); ?>₫</td>
                        <td>
                            <?php if ($p['status'] === 'active'): ?>
                                <span class="badge bg-success">Hiển thị</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Ẩn</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="index.php?page=products&action=edit&id=<?php echo $p['id']; ?>"
                                class="btn btn-warning btn-sm me-1" style="display:inline-block;">Sửa</a>
                            <form method="POST" action="index.php?page=products" style="display:inline-block;"
                                onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                <input type="hidden" name="delete_id" value="<?php echo $p['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="text-center text-muted">Không có sản phẩm nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>