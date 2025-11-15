<div class="container py-5">
    <h2 class="mb-4 text-center">Thanh toán</h2>
    <div class="row g-4">

        <!-- Thông tin khách hàng -->
        <div class="col-md-6">
            <div class="bg-white p-4 rounded shadow-sm">
                <h5 class="mb-3">Thông tin khách hàng</h5>
                <?php if(empty($user['full_name']) || empty($user['phone']) || empty($user['address'])): ?>
                    <div class="alert alert-warning" role="alert">
                        Vui lòng điền đầy đủ thông tin nhận hàng trước!
                    </div>
                <?php endif;?>
                <form>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="fullname" placeholder="<?php echo $user['full_name']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="<?php echo $user['email']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" placeholder="<?php echo $user['phone']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ giao hàng</label>
                        <input type="text" class="form-control" id="address" placeholder="<?php echo $user['address']; ?>" readonly></input>
                    </div>
                </form>
                <div class="mt-4 text-center"> <a href="index.php?page=profile" class="btn btn-danger btn-lg">Sửa thông tin nhận hàng</a> </div>
            </div>
        </div>

        <!-- Tóm tắt giỏ hàng -->
        <div class="col-md-6">
            <div class="bg-white p-4 rounded shadow-sm">
                <h5 class="mb-3">Đơn hàng của bạn</h5>
                <div class="table-responsive">
                    <?php $tong=0 ; ?>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-end">Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cart as $c): ?>
                            <tr>
                                <td><?php echo $c['product_name'];?><br>
                                <small class="text-muted">Size: <?php echo $c['size'];?> | Màu: <?php echo $c['color'];?></small><br>
                                <small class="text-muted">Số lượng: <?php echo $c['quantity'];?></small>
                            </td>
                                <td class="text-end"><?php echo number_format($c['price'] * $c['quantity'], 0, ',', '.'); $tong+=$c['price'] * $c['quantity'];?> vnđ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Tạm tính:</td>
                                <td class="text-end"><?php echo number_format($tong, 0, ',', '.'); ?> vnđ</td>
                            </tr>
                            <tr>
                                <td>Phí vận chuyển:</td>
                                <td class="text-end">Miễn phí</td>
                            </tr>
                            <tr class="fw-bold">
                                <td>Tổng thanh toán:</td>
                                <td class="text-end text-primary"><?php echo number_format($tong, 0, ',', '.'); ?> vnđ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <h5 class="mb-3 mt-4">Phương thức thanh toán</h5>
                <form method="post">
                    <input type="hidden" name="total" value="<?php echo $tong; ?>">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="COD" checked>
                    <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="bank" disabled>
                    <label class="form-check-label" for="bank">Chuyển khoản ngân hàng</label>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="index.php?page=products" class="btn btn-secondary btn-lg">Tiếp tục mua sắm</a>
                    <button class="btn btn-success btn-lg" type="submit">Đặt hàng ngay</button>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>