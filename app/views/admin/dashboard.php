<?php
$stats = $data['stats'] ?? [];
$orderStatuses = $data['orderStatuses'] ?? [];
$monthlyRevenue = $data['monthlyRevenue'] ?? [];
$dailyRevenue = $data['dailyRevenue'] ?? [];
$topProducts = $data['topProducts'] ?? [];

// Lấy max value để scale biểu đồ
$maxDailyRevenue = max(array_values($dailyRevenue)) ?: 1;
$maxMonthlyRevenue = max(array_values($monthlyRevenue)) ?: 1;
?>

<section id="dashboard">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Thống kê nhanh -->
    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card stat-card stat-primary">
                <div class="card-body">
                    <h5 class="card-title">Sản phẩm</h5>
                    <p class="card-text stat-value"><?php echo $stats['total_products']; ?></p>
                    <p class="card-text stat-label">Tổng sản phẩm</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-success">
                <div class="card-body">
                    <h5 class="card-title">Đơn hàng</h5>
                    <p class="card-text stat-value"><?php echo $stats['total_orders']; ?></p>
                    <p class="card-text stat-label">Tổng đơn hàng</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-warning">
                <div class="card-body">
                    <h5 class="card-title">Người dùng</h5>
                    <p class="card-text stat-value"><?php echo $stats['total_users']; ?></p>
                    <p class="card-text stat-label">Tổng người dùng</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-danger">
                <div class="card-body">
                    <h5 class="card-title">Doanh thu</h5>
                    <p class="card-text stat-value"><?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?>₫</p>
                    <p class="card-text stat-label">Tổng doanh thu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ -->
    <div class="row g-4 mb-5">
        <!-- Biểu đồ doanh thu 7 ngày -->
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="mb-0">Doanh thu 7 ngày gần nhất</h5>
                </div>
                <div class="card-body">
                    <div class="bar-chart">
                        <?php foreach ($dailyRevenue as $date => $revenue): 
                            $height = ($maxDailyRevenue > 0) ? ($revenue / $maxDailyRevenue) * 100 : 4; // luôn có cột tối thiểu 4%
                            $dayName = date('d/m', strtotime($date));
                            $barColor = $revenue > 0 ? 'linear-gradient(180deg, #667eea 0%, #764ba2 100%)' : 'linear-gradient(180deg, #e9ecef 0%, #e9ecef 100%)';
                        ?>
                            <div class="bar-item">
                                <div class="bar-value"><?php echo number_format($revenue, 0, ',', '.'); ?></div>
                                <div class="bar" style="height: <?php echo $height; ?>%; background: <?php echo $barColor; ?>"></div>
                                <div class="bar-label"><?php echo $dayName; ?></div>
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
                        <?php foreach ($monthlyRevenue as $month => $revenue): 
                            $height = ($maxMonthlyRevenue > 0) ? ($revenue / $maxMonthlyRevenue) * 100 : 4; // luôn có cột tối thiểu 4%
                            $monthName = date('m/Y', strtotime($month . '-01'));
                            $barColor = $revenue > 0 ? 'linear-gradient(180deg, #667eea 0%, #764ba2 100%)' : 'linear-gradient(180deg, #e9ecef 0%, #e9ecef 100%)';
                        ?>
                            <div class="bar-item">
                                <div class="bar-value"><?php echo number_format($revenue, 0, ',', '.'); ?></div>
                                <div class="bar" style="height: <?php echo $height; ?>%; background: <?php echo $barColor; ?>"></div>
                                <div class="bar-label"><?php echo $monthName; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trạng thái đơn hàng và Top sản phẩm -->
    <div class="row g-4">
        <!-- Trạng thái đơn hàng -->
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="mb-0">Trạng thái đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="status-list">
                        <?php 
                        $statusLabels = [
                            'pending' => ['label' => 'Chờ xử lý', 'color' => '#FF6384'],
                            'processing' => ['label' => 'Đang xử lý', 'color' => '#36A2EB'],
                            'shipped' => ['label' => 'Đã gửi', 'color' => '#FFCE56'],
                            'delivered' => ['label' => 'Đã giao', 'color' => '#4BC0C0'],
                            'cancelled' => ['label' => 'Đã hủy', 'color' => '#9966FF']
                        ];
                        
                        $totalOrders = array_sum($orderStatuses);
                        foreach ($orderStatuses as $status => $count):
                            $percentage = ($totalOrders > 0) ? ($count / $totalOrders) * 100 : 0;
                            $statusInfo = $statusLabels[$status] ?? ['label' => $status, 'color' => '#ccc'];
                        ?>
                            <div class="status-item">
                                <div class="status-info">
                                    <span class="status-label" style="color: <?php echo $statusInfo['color']; ?>">●</span>
                                    <span class="status-name"><?php echo $statusInfo['label']; ?></span>
                                    <span class="status-count"><?php echo $count; ?> đơn</span>
                                </div>
                                <div class="status-bar">
                                    <div class="status-progress" style="width: <?php echo $percentage; ?>%; background-color: <?php echo $statusInfo['color']; ?>"></div>
                                </div>
                                <div class="status-percentage"><?php echo round($percentage, 1); ?>%</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 sản phẩm bán chạy -->
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="mb-0">Top 5 sản phẩm bán chạy</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($topProducts)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-end">Bán</th>
                                        <th class="text-end">Doanh thu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topProducts as $i => $product): ?>
                                        <tr>
                                            <td>
                                                <span class="rank"><?php echo $i + 1; ?></span>
                                                <?php echo htmlspecialchars($product['name']); ?>
                                            </td>
                                            <td class="text-end"><?php echo $product['quantity_sold']; ?></td>
                                            <td class="text-end fw-bold"><?php echo number_format($product['revenue'], 0, ',', '.'); ?>₫</td>
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

<style>
    /* Thống kê card */
    .stat-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-card .card-body {
        padding: 1.5rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0.5rem 0;
        color: inherit;
    }

    .stat-label {
        font-size: 0.9rem;
        color: rgba(0, 0, 0, 0.6);
        margin: 0;
    }

    .stat-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .stat-success { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    .stat-warning { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .stat-danger { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }

    /* Biểu đồ cột */
    .chart-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .chart-card .card-header {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        border-radius: 8px 8px 0 0;
        padding: 1rem 1.5rem;
    }

    .chart-card .card-header h5 {
        color: #333;
        font-weight: 600;
    }

    .bar-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 250px;
        gap: 0.5rem;
    }

    .bar-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        min-width: 0;
    }

    .bar-value {
        font-size: 0.75rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
        height: 1rem;
        display: flex;
        align-items: center;
    }

    .bar {
        width: 100%;
        max-width: 40px;
        /* background sẽ được set inline từ PHP */
        border-radius: 4px 4px 0 0;
        transition: all 0.3s ease;
    }

    .bar:hover {
        filter: brightness(1.2);
    }

    .bar-label {
        font-size: 0.75rem;
        color: #666;
        margin-top: 0.5rem;
        text-align: center;
    }

    /* Trạng thái đơn hàng */
    .status-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .status-item {
        display: grid;
        grid-template-columns: 120px 1fr 50px;
        align-items: center;
        gap: 1rem;
    }

    .status-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .status-label {
        font-size: 1.2rem;
    }

    .status-name {
        font-weight: 600;
        color: #333;
    }

    .status-count {
        color: #666;
        font-size: 0.85rem;
    }

    .status-bar {
        height: 20px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .status-progress {
        height: 100%;
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .status-percentage {
        text-align: right;
        font-weight: 600;
        font-size: 0.85rem;
        color: #333;
        min-width: 50px;
    }

    /* Bảng top sản phẩm */
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    .rank {
        display: inline-block;
        width: 24px;
        height: 24px;
        background: #667eea;
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 24px;
        font-size: 0.75rem;
        font-weight: bold;
        margin-right: 0.5rem;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .bar-chart {
            height: 200px;
        }

        .status-item {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .stat-value {
            font-size: 1.8rem;
        }
    }
</style>