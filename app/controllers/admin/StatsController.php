<?php

require_once __DIR__ . "/../../core/Controller.php";
require_once __DIR__ . "/../../models/Stats.php";

class StatsController extends Controller
{
    private $stats;

    public function __construct()
    {
        $this->stats = new Stats();
    }

    public function list()
    {
        $start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-7 days'));
        $end_date = $_GET['end_date'] ?? date('Y-m-d');

        if (isset($_GET['action']) && $_GET['action'] === 'export') {
            $this->exportExcel($start_date, $end_date);
            return;
        }

        $user = $this->stats->getTotalUser();
        $product = $this->stats->getTotalProduct();
        $order = $this->stats->getTotalOrder($start_date, $end_date);

        $doanhthu = $this->stats->getDayRangeProfit($start_date, $end_date);

        // số lượng hiển thị
        $ntop = 7;
        $topSell = $this->stats->getTopProduct($ntop, $start_date, $end_date);

        $doanhthuNgay = $this->stats->getProfitByDay($start_date, $end_date);

        $this->view('admin/dashboard', [
            'users' => $user,
            'products' => $product,
            'orders' => $order,
            'doanhthu' => $doanhthu,
            'topsell' => $topSell,
            'ntop' => $ntop,
            'status' => $this->statusOrder($start_date, $end_date),
            'doanhthungay' => $doanhthuNgay,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public function statusOrder($start_date = null, $end_date = null)
    {
        $statusOrder = $this->stats->getAllStatusOrder($start_date, $end_date);

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
        $totalOrder = $this->stats->getTotalOrder($start_date, $end_date);

        foreach ($statusOrder as &$s) {
            $status = $s['status'];
            $soluong = $s['total'];
            $s['label'] = $statusLabels[$status]['label'] ?? $status;
            $s['color'] = $statusLabels[$status]['color'] ?? '#ccc';

            // tính phần trăm
            if ($totalOrder > 0) {
                $s['tile'] = round(($soluong / $totalOrder) * 100);
            } else {
                $s['tile'] = 0;
            }
        }

        return $statusOrder;
    }

    public function exportExcel($start_date, $end_date)
    {
        // load library autoload
        require_once __DIR__ . '/../../../vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // fetch data
        $user = $this->stats->getTotalUser();
        $product = $this->stats->getTotalProduct();
        $order = $this->stats->getTotalOrder($start_date, $end_date);
        $doanhthu = $this->stats->getDayRangeProfit($start_date, $end_date);

        $ntop = 7;
        $topSell = $this->stats->getTopProduct($ntop, $start_date, $end_date);
        $statusOrder = $this->statusOrder($start_date, $end_date);

        // Header
        $sheet->setCellValue('A1', 'Thống kê từ ' . $start_date . ' đến ' . $end_date);
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Tổng quan
        $sheet->setCellValue('A3', 'Tổng số sản phẩm');
        $sheet->setCellValue('B3', $product);
        $sheet->setCellValue('A4', 'Tổng số đơn hàng');
        $sheet->setCellValue('B4', $order);
        $sheet->setCellValue('A5', 'Tổng số khách hàng');
        $sheet->setCellValue('B5', $user);
        $sheet->setCellValue('A6', 'Tổng doanh thu');
        $sheet->setCellValue('B6', $doanhthu);

        // Top sản phẩm
        $sheet->setCellValue('A8', 'Top ' . $ntop . ' sản phẩm bán chạy');
        $sheet->mergeCells('A8:D8');
        $sheet->getStyle('A8')->getFont()->setBold(true);
        $sheet->setCellValue('A9', 'STT');
        $sheet->setCellValue('B9', 'Sản phẩm');
        $sheet->setCellValue('C9', 'Đã bán');
        $sheet->setCellValue('D9', 'Doanh thu');

        $row = 10;
        if (!empty($topSell)) {
            foreach ($topSell as $i => $p) {
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $p['name']);
                $sheet->setCellValue('C' . $row, $p['total_sell']);
                $sheet->setCellValue('D' . $row, $p['total_doanhthu']);
                $row++;
            }
        }

        // Trạng thái đơn hàng
        $row += 2;
        $sheet->setCellValue('A' . $row, 'Trạng thái đơn hàng');
        $sheet->mergeCells('A' . $row . ':C' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);

        $row++;
        $sheet->setCellValue('A' . $row, 'Trạng thái');
        $sheet->setCellValue('B' . $row, 'Số lượng');
        $sheet->setCellValue('C' . $row, 'Tỷ lệ (%)');

        $row++;
        if (!empty($statusOrder)) {
            foreach ($statusOrder as $s) {
                $sheet->setCellValue('A' . $row, $s['label']);
                $sheet->setCellValue('B' . $row, $s['total']);
                $sheet->setCellValue('C' . $row, $s['tile']);
                $row++;
            }
        }

        // Auto size columns
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Thong_Ke_' . date('Y_m_d_H_i_s') . '.xlsx';

        // Clear all output buffers before sending headers and excel output
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

}