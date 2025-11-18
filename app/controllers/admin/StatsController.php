<?php 

require_once __DIR__ . "/../../core/Controller.php";
require_once __DIR__ . "/../../models/Stats.php";

class StatsController extends Controller{
    private $stats;

    public function __construct(){
        $this->stats = new Stats();
    }

    public function list(){
        $user = $this->stats->getTotalUser();
        $product = $this->stats->getTotalProduct();
        $order = $this->stats->getTotalOrder();
        $doanhthu = $this->stats->getTotalProfit();

        // số lượng hiển thị
        $ntop = 7;
        $topSell = $this->stats->getTopProduct($ntop);

        $doanthuThang = $this->stats->getProfitByMonth();
        $doanhthuNgay = $this->stats->getProfitByDay();
        
        $this->view('admin/dashboard', [
            'users' => $user,
            'products' => $product,
            'orders' => $order,
            'doanhthu' => $doanhthu,
            'topsell' => $topSell,
            'ntop' => $ntop,
            'status' => $this->statusOrder(),
            'doanhthuthang' => $doanthuThang,
            'doanhthungay' => $doanhthuNgay
        ]);
    }

    public function statusOrder(){
        $statusOrder = $this->stats->getAllStatusOrder();

        // mapping label, color cho status
        $statusLabels = [
            'pending' => ['label' => 'Chờ xử lý', 'color' => '#FF6384'],
            'confirmed' => ['label' => 'Đã xác nhận đơn hàng', 'color' => '#36A2EB'],
            'shipping' => ['label' => 'Đang giao hàng', 'color' => '#36A2EB'],
            'shipped' => ['label' => 'Đã giao hàng', 'color' => '#FFCE56'],
            'delivered' => ['label' => 'Đã nhận hàng', 'color' => '#4BC0C0'],
            'cancelled' => ['label' => 'Đã hủy', 'color' => '#9966FF']
        ];

        // lấy tổng đơn
        $totalOrder = $this->stats->getTotalOrder();

        foreach($statusOrder as &$s){
            $status = $s['status'];
            $soluong = $s['total'];
            $s['label'] = $statusLabels[$status]['label'] ?? $status;
            $s['color'] = $statusLabels[$status]['color'] ?? '#ccc';

            // tính phần trăm
            if($totalOrder > 0){
                $s['tile'] = round(($soluong / $totalOrder) * 100);
            } else {
                $s['tile'] = 0;
            }
        }

        return $statusOrder;
    }


}