<section id="products" class="mt-5">
    <h2 class="mb-3">Quản lý Sản phẩm</h2>
    <?php if (!empty($thongbao)): ?>
        <?php echo $thongbao ?>
    <?php endif; ?>
    <form action="index.php" method="get">
        <input type="hidden" name="page" value="products">
        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm, danh mục">
        <button type="submit">Search</button>
    </form>
    <br>
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
                            <a href="index.php?page=products&action=edit&id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm me-1"
                                style="display:inline-block;">Sửa</a>
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