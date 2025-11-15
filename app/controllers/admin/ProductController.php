<?php
require_once __DIR__ . "/../../models/Product.php";
require_once __DIR__ . "/../../models/Category.php";
require_once __DIR__ . "/../../models/ProductImage.php";
require_once __DIR__ . "/../../models/ProductVariants.php";
require_once __DIR__ . "/../../core/Controller.php";

// require_once __DIR__ . "";

class ProductController extends Controller
{
    private $product;
    private $image;
    private $variant;
    private $categoty;

    public function __construct()
    {
        $this->product = new Product();
        $this->categoty = new Category();
        $this->image = new ProductImage();
        $this->variant = new ProductVariant();
    }

    public function xulyRequest(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['delete_id'])){
                return $this->delete();
            }
            if(isset($_POST['edit_id'])){
                return $this->edit();
            }
            if(isset($_POST['add_sp'])){
                return $this->add();
            }
        } elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
            $a = $_GET['action'] ?? '';
            if(!empty($a) && $a === 'add'){
                return $this->add();
            }
            if(!empty($a) && $a === 'edit' && !empty($_GET['id'])){
                return $this->edit();
            }
        }
        $this->list();
    }

    // load danh sách sản phẩ về trang admin
    public function list()
    {
        $products = $this->product->getAll();
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);
        $this->view('admin/products', [
            'products' => $products,
            'thongbao' => $thongbao
        ]);
    }

    // thêm sản phẩm (admin)
    public function add()
    {
        $categorys = $this->categoty->getAllHome();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // tạo sản phẩm
            $product_id = $this->product->create($_POST['category_id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['status']);

            // xử lý upload
            $upload_dir = __DIR__ . "/../../../public/uploads/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            // ảnh chính
            if (!empty($_FILES['main_image']['name'])) {
                $main_name = $_FILES['main_image']['name'];
                $main_tmp = $_FILES['main_image']['tmp_name'];
                $main_ext = strtolower(pathinfo($main_name, PATHINFO_EXTENSION));

                if (in_array($main_ext, $allowed)) {
                    $main_file = uniqid('main_', true) . "." . $main_ext;
                    $target_file = $upload_dir . $main_file;

                    if (move_uploaded_file($main_tmp, $target_file)) {
                        // lưu vào db, đặt làm ảnh chính 1
                        $this->image->create($product_id, "uploads/" . $main_file, 1);
                    }
                }
            }

            //ảnh phụ
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $original_name = $_FILES['images']['name'][$key];
                    $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

                    if (!in_array($file_ext, $allowed)) continue;

                    $file_name = uniqid('img_', true) . "." . $file_ext;
                    $target_file = $upload_dir . $file_name;

                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $this->image->create($product_id, "uploads/" . $file_name, 0);
                    }
                }
            }

            // thuộc tính sản phẩm
            if (!empty($_POST['variant_color'])) {
                foreach ($_POST['variant_color'] as $i => $color) {
                    $size = $_POST['variant_size'][$i] ?? '';
                    $stock = $_POST['variant_stock'][$i] ?? 0;
                    $color = strtolower($color);

                    if (empty($color) && empty($size) && empty($stock)) continue;

                    // fix dupliace màu, size
                    $dup = $this->variant->getByColorSize($product_id, $color, $size);
                    if($dup){
                        $new = $dup['stock'] + $stock;
                        $this->variant->update($color, $size, $new, $dup['id']);
                    } else {
                        $this->variant->create($product_id, $color, $size, $stock);
                    }
                }
            }

            $_SESSION['thongbao'] = "Thêm sản phẩm thành công";
            $this->redirect('index.php?page=products');
        } else {
            $this->view('admin/product_add', ['categorys' => $categorys]);
        }
    }

    // Xóa sản phẩm (admin)
    public function delete()
    {
        $this->product->delete($_POST['delete_id']);
        $_SESSION['thongbao'] = "Xoá sản phẩm thành công";
        $this->redirect('index.php?page=products');

    }

    // Sửa sản phẩm (admin)
    public function edit()
    {
        $categorys = $this->categoty->getAllHome();

        // khi sumbit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['edit_id'];

            $this->product->update(
                $product_id,
                $_POST['category_id'],
                $_POST['name'],
                $_POST['description'],
                $_POST['price'],
                $_POST['status']
            );

            if (!empty($_FILES['images']['name'][0])) {
                $upload_dir = __DIR__ . "/../../public/uploads/";
                // check dir
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $original_name = $_FILES['images']['name'][$key];
                    $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

                    if (!in_array($file_ext, $allowed)) {
                        continue; // ko up các ảnh ko đúng định dạng
                    }

                    // random name
                    $file_name = uniqid('', true) . "." . $file_ext;
                    $target_file = $upload_dir . $file_name;

                    // upload va luu db
                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $this->image->create($product_id, "uploads/" . $file_name, 0);
                    } else {
                        error_log("Error: " . $original_name);
                    }
                }
            }

            // Xử lý chọn ảnh chính
            if (!empty($_POST['primary_image'])) {
                $primary_id = $_POST['primary_image'];
                // đăt tat ca vè aanhr phụ
                $this->image->setPrimary($product_id, 0);
                // đặt ảnh chính được chọn
                $this->image->updatePrimary($primary_id, 1);
            }

            // Xóa ảnh đã chọn
            if (!empty($_POST['delete_image_ids'])) {
                foreach ($_POST['delete_image_ids'] as $img_id) {
                    $images = $this->image->getUrlById($img_id);
                    if ($images) {
                        $file_path = __DIR__ . "/../../public/" . $images;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                    $this->image->delete($img_id);
                }
            }

            // thuộc tính color, size, stock
            if (!empty($_POST['variant_color'])) {
                foreach ($_POST['variant_color'] as $i => $color) {
                    $size = $_POST['variant_size'][$i];
                    $stock = $_POST['variant_stock'][$i];
                    $variant_id = $_POST['variant_id'][$i];
                    $color = strtolower($color);

                    if ($variant_id) {
                        // Cập nhật thuoocj tính có sẵn
                        $this->variant->update($color, $size, $stock, $variant_id);
                    } else {
                        // fix dupliace màu, size
                        $dup = $this->variant->getByColorSize($product_id, $color, $size);
                        if($dup){
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
