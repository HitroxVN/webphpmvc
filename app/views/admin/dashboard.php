<section id="dashboard">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card stat-card stat-primary">
                <div class="card-body">
                    <h5 class="card-title">Tổng số sản phẩm</h5>
                    <p class="card-text stat-value"><?php echo $products; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-success">
                <div class="card-body">
                    <h5 class="card-title">Tổng số đơn hàng</h5>
                    <p class="card-text stat-value"><?php echo $orders; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-warning">
                <div class="card-body">
                    <h5 class="card-title">Tổng số khách hàng</h5>
                    <p class="card-text stat-value"><?php echo $users; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-danger">
                <div class="card-body">
                    <h5 class="card-title">Tổng doanh thu</h5>
                    <p class="card-text stat-value"><?php echo number_format($doanhthu, 0, ',', '.'); ?> vnđ</p>
                </div>
            </div>
        </div>

        <!-- Biểu đồ doanh thu 7 ngày -->
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="mb-0">Doanh thu 7 ngày gần nhất</h5>
                </div>
                <div class="card-body">
                    <div class="bar-chart">

                        <?php
                        $maxdt = !empty($doanhthungay) ? max(array_column($doanhthungay, 'doanhthu')) : 0;

                        foreach ($doanhthungay as $dtt):
                            $date = $dtt['day'];
                            $revenue = (float) $dtt['doanhthu'];

                            $height = ($maxdt > 0) ? ($revenue / $maxdt) * 100 : 4;

                            $dayName = date('d/m', strtotime($date));

                            $barColor = $revenue > 0
                                ? 'linear-gradient(180deg, #667eea 0%, #764ba2 100%)'
                                : 'linear-gradient(180deg, #e9ecef 0%, #e9ecef 100%)';
                            ?>

                            <div class="bar-item">
                                <div class="bar-value"><?= number_format($revenue, 0, ',', '.'); ?></div>
                                <div class="bar" style="height: <?= $height ?>%; background: <?= $barColor ?>;"></div>
                                <div class="bar-label"><?= $dayName; ?></div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>

        
        <!-- Biểu đồ doanh thu 6 tháng -->
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="mb-0">Doanh thu 6 tháng gần nhất</h5>
                </div>
                <div class="card-body">
                    <div class="bar-chart">
                        <?php
                        // Tìm giá trị max để chuẩn hóa chiều cao
                        $maxdt = !empty($doanhthuthang) ? max(array_column($doanhthuthang, 'doanhthu')) : 0;

                        foreach ($doanhthuthang as $dtt):
                            $month = $dtt['month'];
                            $revenue = (float) $dtt['doanhthu'];
                            $height = ($maxdt > 0) ? ($revenue / $maxdt) * 100 : 4;
                            $monthName = date('m/Y', strtotime($month . '-01'));
                            $barColor = $revenue > 0
                                ? 'linear-gradient(180deg, #667eea 0%, #764ba2 100%)'
                                : 'linear-gradient(180deg, #e9ecef 0%, #e9ecef 100%)';
                            ?>
                            <div class="bar-item">
                                <div class="bar-value"><?= number_format($revenue, 0, ',', '.'); ?></div>
                                <div class="bar" style="height: <?= $height; ?>%; background: <?= $barColor; ?>"></div>
                                <div class="bar-label"><?= $monthName; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- trạng thái đơn hàng -->
            <div class="col-md-6">
                <div class="card chart-card">
                    <div class="card-header">
                        <h5 class="mb-0">Trạng thái đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="status-list">

                            <?php foreach ($status as $item): ?>
                                <div class="status-item">

                                    <div class="status-info">
                                        <span class="status-label" style="color: <?= $item['color']; ?>">●</span>
                                        <span class="status-name"><?= $item['label']; ?></span>
                                        <span class="status-count"><?= $item['total']; ?> đơn</span>
                                    </div>

                                    <div class="status-bar">
                                        <div class="status-progress"
                                            style="width: <?= $item['tile']; ?>%; background-color: <?= $item['color']; ?>;">
                                        </div>
                                    </div>

                                    <div class="status-percentage"><?= $item['tile']; ?>%</div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>



        <!-- top sản phâm bán chạy -->
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="mb-0">Top <?php echo $ntop ?> sản phẩm bán chạy</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($topsell)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-end">Đã bán</th>
                                        <th class="text-end">Doanh thu sản phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topsell as $i => $product): ?>
                                        <tr>
                                            <td>
                                                <span class="rank"><?php echo $i + 1; ?></span>
                                                <?php echo $product['name']; ?>
                                            </td>
                                            <td class="text-end"><?php echo $product['total_sell']; ?></td>
                                            <td class="text-end fw-bold">
                                                <?php echo number_format($product['total_doanhthu'], 0, ',', '.'); ?>₫
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4">Chưa có dữ liệu</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>