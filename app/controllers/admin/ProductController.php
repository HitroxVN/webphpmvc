<?php
require_once __DIR__ . "/../../models/Product.php";
require_once __DIR__ . "/../../models/Category.php";
require_once __DIR__ . "/../../models/ProductImage.php";
require_once __DIR__ . "/../../models/ProductVariants.php";
require_once __DIR__ . "/../../core/Controller.php";

// require_once __DIR__ . "";

// thừa kế lại class controller mặc định là có hai hàm view và rdirect
class ProductController extends Controller
{
    private $product;
    private $image;
    private $variant;
    private $categoty;


    protected $dir = __DIR__ . "/../../../public/";
    public function __construct()
    {
        // khởi tạo các đối tượng class
        $this->product = new Product();
        $this->categoty = new Category();
        $this->image = new ProductImage();
        $this->variant = new ProductVariant();
    }


    // hàm lấy ra đường dẫn file uploads
    protected function upload_dir()
    {
        return $this->dir . "uploads/";
    }


    // sử lý request
    public function xulyRequest()
    {
        // kiểm tra nếu gửi với methoh post thì vào đây
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // kiểm tra biến delete_id với method post có tồn tại ko
            if (isset($_POST['delete_id'])) {
                // gọi đến hàm delete
                return $this->delete();
            }
            // kiểm tra biến edit_id với method post có tồn tại ko
            if (isset($_POST['edit_id'])) {
                // gọi đến hàm edit
                return $this->edit();
            }
            // kiểm tra biến add_sp với method post có tồn tại ko
            if (isset($_POST['add_sp'])) {
                // gọi đến hàm add
                return $this->add();
            }
            // kiểm tra nếu gửi với methoh get thì vào đây
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // kiểm tra hành động nếu có gán và biến a
            $a = $_GET['action'] ?? '';
            // kiểm tra xem biến a có ko rỗng và bằng với "add"
            if (!empty($a) && $a === 'add') {
                // gọi đến hàm add
                return $this->add();
            }
            // kiểm tra xem biến a có ko rỗng và bằng với "edit"
            if (!empty($a) && $a === 'edit' && !empty($_GET['id'])) {
                // gọi đến hàm edit
                return $this->edit();
            }
            // kiểm tra biến search có tồn tại hay ko
            if (!empty($_GET['search'])) {
                // gọi đến hàm search
                return $this->search();
            }
        }
        // gọi đến hàm list
        return $this->list();
    }

    // load danh sách sản phẩ về trang admin
    public function list()
    {
        // gọi đến hàm get all lấy ra tất cả sản phẩm kể cả ko hoạt động
        $products = $this->product->getAll();
        // kiểm tra thông báo trước đó xem có hay ko nếu có gán vào thông báo
        $thongbao = $_SESSION['thongbao'] ?? null;
        // lập tức xóa luôn thông báo trong section 
        unset($_SESSION['thongbao']);

        //trả về đường dẫn view/admin/products với biến dữ liệu
        $this->view('admin/products', [
            'products' => $products,
            'thongbao' => $thongbao
        ]);
    }


    public function search()
    {
        // gọi đến hàm tìm kiếm admin cả tk đc cả sp ẩn
        $products = $this->product->findProductAdmin($_GET['search']);
        // kiểm tra thông báo trước đó xem có hay ko nếu có gán vào thông báo
        $thongbao = $_SESSION['thongbao'] ?? null;
        // lập tức xóa luôn thông báo trong section 
        unset($_SESSION['thongbao']);
        //trả về đường dẫn file view với biến dữ liệu
        $this->view('admin/products', [
            'products' => $products,
            'thongbao' => $thongbao
        ]);
    }

    // thêm sản phẩm (admin)
    public function add()
    {
        // lấy ra danh sách thể loại hoạt động
        $categorys = $this->categoty->getAllHome();
        // kiểm tra xem phải method post ko
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // lưu lại sản phẩm
            $product_id = $this->product->create($_POST['category_id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['status']);

            // xử lý upload
            // $upload_dir = __DIR__ . "/../../../public/uploads/";
            // kiểm tra xem thư mục này có tồn tại hay ko nếu chưa có thì tạo mới
            if (!is_dir($this->upload_dir())) mkdir($this->upload_dir(), 0777, true);
            // khai bảo mảng đường dẫn các file đuôi cho phép
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'avif'];

            // ảnh chính
            // kiểm tra xem tên ảnh của biến có name"main_image" có hay ko
            if (!empty($_FILES['main_image']['name'])) {
                // tạo biết tên ảnh người dùng up
                $main_name = $_FILES['main_image']['name'];
                // lấy ra đường dẫn tạm thời
                $main_tmp = $_FILES['main_image']['tmp_name'];
                // lấy đôi của file người dùng up
                $main_ext = strtolower(pathinfo($main_name, PATHINFO_EXTENSION));

                // kiểm tra xem nó có nằm trong đuôi cho phép hay ko
                if (in_array($main_ext, $allowed)) {
                    // tạo ra tên ảnh ngẫu nhiên main_(....) .đuôi file 
                    $main_file = uniqid('main_', true) . "." . $main_ext;
                    // biến này chứa đầy đủ đường dẫn file
                    $target_file = $this->upload_dir() . $main_file;

                    // chuyển ảnh từ đường dẫn flie tam thời sang đường dẫn file đúng
                    if (move_uploaded_file($main_tmp, $target_file)) {
                        // lưu vào db, đặt làm ảnh chính 1
                        $this->image->create($product_id, "uploads/" . $main_file, 1);
                    }
                }
            }

            //ảnh phụ
            // kiểm tra tên file đầu tiên người dùng upload có tồn tại hay ko
            if (!empty($_FILES['images']['name'][0])) {
                // duyệt qua tất cả đường dẫn tạm thời của ảnh với key 0- số lượng file-1
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    // lấy ra  tên ảnh người dùng up
                    $original_name = $_FILES['images']['name'][$key];
                    // lấy ra đuôi ảnh
                    $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

                    // kiểm tra xem nếu đuôi ảnh ko nằm đuôi cho phép thoát đi vòng tiếp theo
                    if (!in_array($file_ext, $allowed)) continue;

                    // tạo ra tên ảnh ngẫu nhiên main_(....) .đuôi file 
                    $file_name = uniqid('img_', true) . "." . $file_ext;
                    // biến này chứa đầy đủ đường dẫn file
                    $target_file = $this->upload_dir() . $file_name;

                    //chuyển ảnh từ đường dẫn flie tam thời sang đường dẫn file đúng
                    if (move_uploaded_file($tmp_name, $target_file)) {
                        // lưu vào cơ sở dữ liệu với 0 là ảnh phụ
                        $this->image->create($product_id, "uploads/" . $file_name, 0);
                    }
                }
            }

            // thuộc tính sản phẩm
            // kiểm tra biến màu sắc có tồn tại hay ko
            if (!empty($_POST['variant_color'])) {
                // duyệt qua tất cả các biến màu sắc và key 0-số lượng up
                foreach ($_POST['variant_color'] as $i => $color) {
                    // biến kích thước thứ i nếu có ko thì gán ""
                    $size = $_POST['variant_size'][$i] ?? '';
                    // biến số lượng thứ i nếu có ko thì gán là 0
                    $stock = $_POST['variant_stock'][$i] ?? 0;
                    // chuyển màu sắc về chung viết thường
                    $color = strtolower($color);

                    // nêu cả 3 biến này rỗng thì bỏ qua
                    if (empty($color) && empty($size) && empty($stock)) continue;

                    // biến lấy ra sản phẩm có mầu sắc giống với người dùng up
                    $dup = $this->variant->getByColorSize($product_id, $color, $size);
                    // nếu biến này có 
                    if ($dup) {
                        // tăng số lượng lên
                        $new = $dup['stock'] + $stock;
                        // cập nhập lại số lượng 
                        $this->variant->update($color, $size, $new, $dup['id']);
                    } else {
                        // trường hợp còn lại thêm mới
                        $this->variant->create($product_id, $color, $size, $stock);
                    }
                }
            }
            // tạo biến thôn báo
            $_SESSION['thongbao'] = "Thêm sản phẩm thành công";
            // chuyển hướng người dùng về trang chủ với page product
            $this->redirect('index.php?page=products');
        } else {
            // nếu method get thì hiển thị ra giao diện và trả list các sản phẩm
            $this->view('admin/product_add', ['categorys' => $categorys]);
        }
    }

    // Xóa sản phẩm (admin)
    public function delete()
    {
        // lấy ra đường dẫn ảnh theo id sản phẩm
        $img = $this->image->getByProductId($_POST['delete_id']);
        // duyệt qua tất cả ảnh
        foreach ($img as $i) {
            // lấy đướng dẫn ảnh
            $file = $this->dir . $i['image_url'];
            // nếu file tồn tại
            if (file_exists($file)) {
                // xóa ảnh theo đường dẫn ảnh
                unlink($file);
            }
        }
        //ON DELETE CASCADE;  khi xóa cha thid lệnh con cũng bị xóa theo
        $this->product->delete($_POST['delete_id']);
        $_SESSION['thongbao'] = "Xoá sản phẩm thành công";
        $this->redirect('index.php?page=products');
    }

    // Sửa sản phẩm (admin)
    public function edit()
    {
        // lấy ra danh sách danh mục
        $categorys = $this->categoty->getAllHome();

        // khi khi người dùng bấm submit với method post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // lấy ra biến id sp
            $product_id = $_POST['edit_id'];

            // up datate các trường sản phẩm
            $this->product->update(
                $product_id,
                $_POST['category_id'],
                $_POST['name'],
                $_POST['description'],
                $_POST['price'],
                $_POST['status']
            );
            // nếu thêm ảnh up load
            // kiểm tra xem tên của biến file ảnh đầu tiên
            if (!empty($_FILES['images']['name'][0])) {
                // $upload_dir = __DIR__ . "/../../../public/uploads/";
                // check dir
                if (!is_dir($this->upload_dir())) mkdir($this->upload_dir(), 0777, true);
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $original_name = $_FILES['images']['name'][$key];
                    $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

                    if (!in_array($file_ext, $allowed)) {
                        continue; // ko up các ảnh ko đúng định dạng
                    }

                    // random name
                    $file_name = uniqid('', true) . "." . $file_ext;
                    $target_file = $this->upload_dir() . $file_name;

                    // upload va luu db
                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $this->image->create($product_id, "uploads/" . $file_name, 0);
                    } else {
                        error_log("Error: " . $original_name);
                    }
                }
            }

            // Xử lý chọn ảnh chính nếu người dùng tích vào ảnh nào thì ảnh đấy là ảnh chính
            // kiểm tra xem biến này có phải biến rỗng hay ko
            if (!empty($_POST['primary_image'])) {
                // lấy ra id sản phẩm
                $primary_id = $_POST['primary_image'];
                // đăt tat ca vè aanhr phụ
                $this->image->setPrimary($product_id, 0);
                // đặt ảnh chính được chọn
                $this->image->updatePrimary($primary_id, 1);
            }

            // Xóa ảnh đã chọn
            // kiểm tra xem biến delete_image_ids có ko rỗng hay ko
            if (!empty($_POST['delete_image_ids'])) {
                // duyệt qua tất cả ảnh đã đc tích xóa với id ảnh
                foreach ($_POST['delete_image_ids'] as $img_id) {
                    // lấy ra tên ảnh ảnh theo id
                    $images = $this->image->getUrlById($img_id);
                    if ($images) {
                        $file_path = $this->dir . $images;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                    $this->image->delete($img_id);
                }
            }

            // thuộc tính color, size, stock
            if (!empty($_POST['variant_color'])) {
                // duyết qua tất cả các mầu id : tên màu 
                foreach ($_POST['variant_color'] as $i => $color) {
                    $size = $_POST['variant_size'][$i];
                    $stock = $_POST['variant_stock'][$i];
                    $variant_id = $_POST['variant_id'][$i];
                    $color = strtolower($color);

                    //nếu  lấy ra những cái thuộc tính cũ thì cập nhâp
                    // nếu thuộc tính cũ id tồn tại
                    if ($variant_id) {
                        // Cập nhật thuoocj tính có sẵn
                        $this->variant->update($color, $size, $stock, $variant_id);
                    } else {
                        // fix dupliace màu, size
                        $dup = $this->variant->getByColorSize($product_id, $color, $size);
                        if ($dup) {
                            $new = $dup['stock'] + $stock;
                            $this->variant->update($color, $size, $new, $dup['id']);
                        } else {
                            // Thêm thuộc tính mới
                            $this->variant->create($product_id, $color, $size, $stock);
                        }
                    }
                }
            }

            // Xóa thuộc tính
            if (!empty($_POST['delete_variant_ids'])) {
                foreach ($_POST['delete_variant_ids'] as $v_id) {
                    $this->variant->delete($v_id);
                }
            }
            $_SESSION['thongbao'] = "Cập nhập sản phẩm thành công";
            $this->redirect('index.php?page=products');
            return;
        }

        // hiển thị form khi GET
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $products = $this->product->getById($id);
            $images = $this->image->getByProductId($id);
            $variants = $this->variant->getByProductId($id);

            $this->view('admin/product_edit', [
                'categorys' => $categorys,
                'product'   => $products,
                'images'    => $images,
                'variants'  => $variants
            ]);
            return;
        }

        $this->redirect('index.php?page=products');
    }
}
