<div class="container py-5">
    <h2 class="mb-4 text-center">Giỏ hàng của bạn</h2>

    <!-- CART TABLE -->
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <?php $tong = 0; ?>
        <?php if (!empty($carts)): ?>
            <table class="table align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col" class="text-center">Số lượng</th>
                        <th scope="col" class="text-end">Giá sản phẩm</th>
                        <th scope="col" class="text-end">Tổng tiền sản phẩm</th>
                        <th scope="col" class="text-center">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- sản phẩm -->
                    <?php foreach ($carts as $c): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $c['image_url']; ?>" class="rounded me-3" width="70" height="70">
                                    <div>
                                        <h6 class="mb-1"><a href="index.php?page=products&id=<?php echo $c['product_id']; ?>" class="text-decoration-none text-dark">
                                                <?php echo $c['product_name']; ?>
                                            </a></h6>
                                        <small class="text-muted">Size: <?php echo $c['size']; ?></small><br>
                                        <small class="text-muted">Loại màu: <?php echo $c['color']; ?></small>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center align-middle">
                                <form method="post" class="d-inline">
                                    <div class="input-group input-group-sm justify-content-center" style="max-width: 150px; margin: 0 auto;">

                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Giảm" onclick="decreaseQuantity(<?php echo $c['cart_id']; ?>)">
                                            <i class="bi bi-dash"></i>
                                        </button>

                                        <input
                                            type="number"
                                            name="quantity[<?php echo $c['cart_id']; ?>]"
                                            id="quantity-<?php echo $c['cart_id']; ?>"
                                            value="<?php echo $c['quantity']; ?>"
                                            min="1"
                                            class="form-control text-center"
                                            style="max-width: 60px;">

                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Tăng" onclick="increaseQuantity(<?php echo $c['cart_id']; ?>)">
                                            <i class="bi bi-plus"></i>
                                        </button>

                                        <button type="submit" name="update_cart" value="1" class="btn btn-outline-success" data-bs-toggle="tooltip" title="Cập nhật">
                                            <i class="bi bi-repeat"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>


                            <td class="text-end"><?php echo number_format($c['price'], 0, ',', '.'); ?> vnđ</td>
                            <td class="text-end fw-bold"><?php echo number_format($c['price'] * $c['quantity'], 0, ',', '.');
                                                            $tong += ($c['price'] * $c['quantity']); ?> vnđ</td>
                            <td class="text-center">
                                <form method="post">
                                    <input type="hidden" name="delete_cart" value="<?php echo $c['cart_id']; ?>">
                                    <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="bi bi-trash3"></i>    
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        <?php else: ?>
            <h3 class="mb-4 text-center">Bạn chưa thêm sản phẩm nào
                <a href="index.php?page=products">Mua hàng ngay</a>
            </h3>
        <?php endif; ?>
    </div>

    <!-- TOTAL -->
    <div class="row mt-4">
        <div class="col-md-6 offset-md-6">
            <div class="bg-white p-4 rounded shadow-sm">
                <h5 class="mb-3">Tổng cộng</h5>
                <div class="d-flex justify-content-between">
                    <span>Tạm tính:</span>
                    <strong><?php echo number_format($tong, 0, ',', '.'); ?> vnđ</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Phí vận chuyển:</span>
                    <strong>Miễn phí</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between fs-5">
                    <strong>Tổng thanh toán:</strong>
                    <strong class="text-primary"><?php echo number_format($tong, 0, ',', '.'); ?> vnđ</strong>
                </div>
                <div class="mt-4 d-flex justify-content-between">
                    <a href="index.php?page=products" class="btn btn-danger btn-lg">Tiếp tục mua sắm</a>
                    <a href="index.php?page=checkout" class="btn btn-success btn-lg">Thanh toán ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    function increaseQuantity(id) {
        const input = document.querySelector(`input[name="quantity[${id}]"]`);
        if (input) input.value = parseInt(input.value || 1) + 1;
    }

    function decreaseQuantity(id) {
        const input = document.querySelector(`input[name="quantity[${id}]"]`);
        if (input && parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    }
</script>