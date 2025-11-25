<?php
require_once __DIR__ . "/../../models/User.php";
require_once __DIR__ . "/../../models/Order.php";
require_once __DIR__ . "/../../models/OrderItems.php";
require_once __DIR__ . "/../../core/Controller.php";

class OrderController extends Controller {
    private $user;
    private $order;
    private $order_item;

    public function __construct()
    {
        $this->user = new User();
        $this->order = new Order();
        $this->order_item = new OrderItems();
    }

    public function xulyRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // xem chi tieets down hang
            if (!empty($_GET['id'])) {
                return $this->detailsAdmin();
            }
            if(!empty($_GET['user'])){
                // echo "test" . $_GET['user'];
                return $this->listByUserId();
            }

            // lọc trạng thái đơn hàng
            if(!empty($_GET['loc_orders'])){
                return $this->loc_orders();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // cap nhap trang thai don hang
            if (!empty($_POST['status_update'])) {
                return $this->edit();
            }
        }

        return $this->list();
    }

    /// xem danh sách đơn hàng của user
    public function listByUserId(){
        $u = $this->user->getById($_GET['user']);

        // bỏ qua role admin
        if($u['role'] == 'admin'){
            $this->redirect("index.php?page=users");
            return;
        }

        // fix truyền id null
        if(!$u){
            $this->redirect("index.php?page=users");
            return;
        }
        $orders = $this->order->getByUser($_GET['user']);
        $thongbao = !$orders ? "Người dùng chưa đặt đơn nào." : "Danh sách đơn hàng của {$orders[0]['email']}";
        $this->view('staff/orders', [
            'order' => $orders,
            'thongbao' => $thongbao
        ]);
    }

    // view for admin
    public function list(){
        $orders = $this->order->getAll();
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);

        $this->view('staff/orders', [
            'order' => $orders,
            'thongbao' => $thongbao
        ]);
    }

    // lọc trạng thái đơn hàng
    public function loc_orders(){
        $orders = $this->order->getByStatus($_GET['loc_orders']);
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);

        $this->view('staff/orders', [
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
        $this->view('staff/order_details', [
            'order' => $orders,
            'user' => $user,
            'o_items' => $order_items
        ]);
    }

}