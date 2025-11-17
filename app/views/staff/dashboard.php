<section id="dashboard">
    <h2 class="mb-4">Dashboard</h2>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-bg-primary text-center">
                <div class="card-body">
                    <h5 class="card-title">Tổng số sản phẩm</h5>
                    <p class="card-text fs-4"><?php echo $products; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success text-center">
                <div class="card-body">
                    <h5 class="card-title">Tổng số đơn hàng</h5>
                    <p class="card-text fs-4"><?php echo $orders; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning text-center">
                <div class="card-body">
                    <h5 class="card-title">Tổng số khách hàng</h5>
                    <p class="card-text fs-4"><?php echo $users; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-danger text-center">
                <div class="card-body">
                    <h5 class="card-title">Tổng doanh thu</h5>
                    <p class="card-text fs-4"><?php echo number_format($doanhthu, 0, ',', '.'); ?> vnđ</p>
                </div>
            </div>
        </div>
    </div>
</section>