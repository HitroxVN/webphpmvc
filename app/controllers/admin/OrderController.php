<?php
require_once __DIR__ . "/../../models/User.php";
require_once __DIR__ . "/../../models/Order.php";
require_once __DIR__ . "/../../models/OrderItems.php";
require_once __DIR__ . "/../../models/ProductVariants.php";
require_once __DIR__ . "/../../core/Controller.php";

class OrderController extends Controller {
    private $user;
    private $order;
    private $order_item;
    private $variant;

    public function __construct()
    {
        $this->user = new User();
        $this->order = new Order();
        $this->order_item = new OrderItems();
        $this->variant = new ProductVariant();
    }

    public function xulyRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // xem chi tieets down hang
            if (!empty($_GET['id'])) {
                return $this->detailsAdmin();
            }
            // lọc trạng thái đơn hàng
            if(!empty($_GET['loc_orders'])){
                return $this->loc_orders();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
                return $this->cancel();
            }
            // cap nhap trang thai don hang
            if (!empty($_POST['status_update'])) {
                return $this->edit();
            }
        }

        return $this->list();
    }

    // view for admin
    public function list(){
        $orders = $this->order->getAll();
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);

        $this->view('admin/orders', [
            'order' => $orders,
            'thongbao' => $thongbao
        ]);
    }

    // lọc trạng thái đơn hàng
    public function loc_orders(){
        $orders = $this->order->getByStatus($_GET['loc_orders']);
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);

        $this->view('admin/orders', [
            'order' => $orders,
            'thongbao' => $thongbao
        ]);
    }

    // câp nhâp trạng thái
    public function edit()
    {
        $status = $_POST['status_update'];
        $oid = $_POST['order_id'];
        $this->order->updateStatus($status, $oid);
        $_SESSION['thongbao'] = "Cập nhập đơn hàng thành công";
        $this->redirect('index.php?page=orders');
    }

    // chi tiết đơn hàng
    public function detailsAdmin()
    {
        $id = $_GET['id'];
        $orders = $this->order->getById($id);
        $user = $this->user->getById($orders['user_id']);
        $order_items = $this->order_item->getByOrderId($id);

        $this->view('admin/order_details', [
            'order' => $orders,
            'user' => $user,
            'o_items' => $order_items
        ]);
    }

    public function cancel()
    {
        if (empty($_POST['order_id'])) {
            $this->redirect('index.php?page=orders');
            return;
        }

        $oid = $_POST['order_id'];
        $order = $this->order->getById($oid);

        if ($order && $order['status'] === 'pending') {
            // Restore stock
            $order_items = $this->order_item->getByOrderId($oid);
            foreach ($order_items as $item) {
                $vid = $item['variant_id'];
                $qty = $item['quantity'];

                $v = $this->variant->getById($vid);
                if ($v) {
                    $new_stock = $v['stock'] + $qty;
                    $this->variant->update($v['color'], $v['size'], $new_stock, $vid);
                }
            }

            $this->order->updateStatus('cancelled', $oid);
            $_SESSION['thongbao'] = "Đã huỷ đơn hàng #" . $oid;
        } else {
            $_SESSION['thongbao'] = "Không thể huỷ đơn hàng này (chỉ đơn chưa xác nhận mới có thể huỷ).";
        }

        $this->redirect('index.php?page=orders');
    }

}