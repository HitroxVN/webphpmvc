<?php
require_once __DIR__ . "/../../models/Order.php";
require_once __DIR__ . "/../../models/OrderItems.php";
require_once __DIR__ . "/../../models/ProductImage.php";
require_once __DIR__ . "/../../models/ProductVariants.php";
require_once __DIR__ . "/../../core/Controller.php";

class OrderController extends Controller
{
    private $order;
    private $order_item;
    private $product_image;
    private $variant;

    public function __construct()
    {
        $this->order = new Order();
        $this->order_item = new OrderItems();
        $this->product_image = new ProductImage();
        $this->variant = new ProductVariant();
    }

    public function xulyRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // xem chi tieets down hang
            if (!empty($_GET['id'])) {
                return $this->detailsId($_GET['id']);
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
                return $this->cancel();
            }
        }

        return $this->list();
    }

    // view for user
    public function list()
    {
        $uid = $_SESSION['user']['id'];
        $all_orders = $this->order->getByUser($uid);
        
        // Phân trang
        $items_per_page = 4;
        $current_page = isset($_GET['pagination']) ? max(1, intval($_GET['pagination'])) : 1;
        $total_items = count($all_orders);
        $total_pages = ceil($total_items / $items_per_page);
        
        // Điều chỉnh trang nếu vượt quá tổng trang
        if($current_page > $total_pages && $total_pages > 0) {
            $current_page = $total_pages;
        }
        
        // Lấy items cho trang hiện tại
        $offset = ($current_page - 1) * $items_per_page;
        $orders = array_slice($all_orders, $offset, $items_per_page);
        
        // Lấy thông tin sản phẩm và ảnh cho mỗi đơn hàng
        foreach($orders as &$order) {
            $items = $this->order_item->getByOrderId($order['id']);
            if(!empty($items)) {
                $order['product_name'] = $items[0]['product_name'] ?? 'Sản phẩm';
                $order['quantity'] = count($items);
                $order['main_image'] = $items[0]['image_url'] ?? null;
            }
        }
        
        $this->view('home/order', [
            'order' => $orders,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'total_items' => $total_items
        ]);
    }

    // chi tiết đơn hàng
    public function detailsId($id)
    {
        $orders = $this->order->getById($id);

        // chặn xem đơn của người khác
        if ($orders['user_id'] != $_SESSION['user']['id']) {
            $this->redirect("index.php?page=orders");
            exit;
        }
        $order_items = $this->order_item->getByOrderId($id);

        $this->view('home/order_details', [
            'order' => $orders,
            'o_items' => $order_items
        ]);
    }

    // huỷ đơn hàng
    public function cancel()
    {
        if (empty($_POST['order_id'])) {
            $this->redirect("index.php?page=orders");
            return;
        }

        $orderId = $_POST['order_id'];
        $order = $this->order->getById($orderId);

        if (!$order) {
            // order not found
            $this->redirect("index.php?page=orders");
            return;
        }

        if ($order['user_id'] != $_SESSION['user']['id']) {
            // not login
            $this->redirect("index.php?page=orders");
            return;
        }

        if ($order['status'] === 'pending') {
            // Restore stock
            $order_items = $this->order_item->getByOrderId($orderId);
            foreach ($order_items as $item) {
                $vid = $item['variant_id'];
                $qty = $item['quantity'];

                $v = $this->variant->getById($vid);
                if ($v) {
                    $new_stock = $v['stock'] + $qty;
                    $this->variant->update($v['color'], $v['size'], $new_stock, $vid);
                }
            }

            $this->order->updateStatus('cancelled', $orderId);
            $_SESSION['thongbao'] = "Đã huỷ đơn hàng #" . $orderId;
        } else {
            $_SESSION['thongbao'] = "Không thể huỷ đơn hàng này (chỉ đơn chưa xác nhận mới có thể huỷ).";
        }

        $this->redirect("index.php?page=orders");
    }
}