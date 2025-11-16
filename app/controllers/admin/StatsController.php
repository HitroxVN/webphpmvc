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

        $this->view('admin/dashboard', [
            'users' => $user,
            'products' => $product,
            'orders' => $order,
            'doanhthu' => $doanhthu
        ]);
    }
}