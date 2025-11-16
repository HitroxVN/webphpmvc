<?php 
require_once __DIR__ . "/../../models/Order.php";
require_once __DIR__ . "/../../models/OrderItems.php";
require_once __DIR__ . "/../../core/Controller.php";

class OrderController extends Controller {
    private $order;
    private $order_item;

    public function __construct()
    {
        $this->order = new Order();
        $this->order_item = new OrderItems();
    }

    public function xulyRequest(){
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            // xem chi tieets down hang
            if(!empty($_GET['id'])){
                return $this->detailsId($_GET['id']);
            }
        }

        return $this->list();
    }

    // view for user
    public function list(){
        $uid = $_SESSION['user']['id'];
        $orders = $this->order->getByUser($uid);
        $this->view('home/order', ['order' => $orders]);
    }

    // chi tiết đơn hàng
    public function detailsId($id){
        $orders = $this->order->getById($id);

        // chặn xem đơn của người khác
        if($orders['user_id'] != $_SESSION['user']['id']) {
            $this->redirect("index.php?page=orders");
            exit;
        }
        $order_items = $this->order_item->getByOrderId($id);

        $this->view('home/order_details', [
            'order' => $orders,
            'o_items' => $order_items
        ]);
    }
}