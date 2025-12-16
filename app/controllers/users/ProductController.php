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

    public function xulyRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!empty($_GET['id'])) {
                return $this->productDetails($_GET['id']);
            }
            if (!empty($_GET['search'])) {
                // echo "search";
                return $this->findP();
            }
            if (!empty($_GET['min_price']) || !empty($_GET['max_price'])) {
                return $this->loc_gia();
            }
        }
        return $this->listProduct();
    }

    // tim kiếm sản phẩm theo tên
    public function findP()
    {
        // lấy danh sách sản phẩm sau khi tìm kiếm
        $pro = $this->product->findProduct($_GET['search']);
        foreach ($pro as &$p) {
            // lấy ra tất cả ảnh chính theo id sp
            $p['main_image'] = $this->image->getPrimaryImage($p['id']);
        }
        $this->view('home/products', ['products' => $pro]);
    }

    // lọc theo giá
    public function loc_gia()
    {
        $min = $_GET['min_price'] ?? null;
        $max = $_GET['max_price'] ?? null;

        $products = $this->product->loc_gia($min, $max);
        foreach ($products as &$p) {
            $p['main_image'] = $this->image->getPrimaryImage($p['id']);
        }
        $this->view('home/products', ['products' => $products]);
    }

    // về trang san phẩm
    public function listProduct()
    {
        $products = $this->product->getAllHome();
        foreach ($products as &$p) {
            $p['main_image'] = $this->image->getPrimaryImage($p['id']);
        }
        $this->view('home/products', ['products' => $products]);
    }

    // chi tiết sản phaam
    public function productDetails($id)
    {
        // lấy sp theo id sản phẩm
        $products = $this->product->getById($id);

        // fix truyền tham số sp null, sp bị ẩn
        if (!$products || $products['status'] === 'hide') {
            $this->redirect("index.php?page=products");
            exit;
        }

        // lấy ra tất cả ảnh sản phẩm theo id sp
        $products['main_image'] = $this->image->getPrimaryImage($products['id']);
        // lấy ra tất cả ảnh sản phẩm theo id sp
        $products['list_images'] = $this->image->getUrlByProduct($products['id']);
        // lấy ra tất cả thuộc tính theo id sp
        $variants = $this->variant->getByProductId($products['id']);

        $colors = [];
        $sizes = [];
        $totalStock = 0;
        $vid = null;

        $sizeGroups  = [];

        foreach ($variants as $v) {
            // mếu mầu sắc chưa có
            if (!in_array($v['color'], $colors)) {
                // thêm vào trong color
                $colors[] = $v['color'];
            }
            // nêu chưa có kích thước
            if (!in_array($v['size'], $sizes)) {
                // thêm vào trong kích thưcos
                $sizes[] = $v['size'];
            }
            // gán id thuộc tính
            $vid = $v['id'];
            // lâyus số lượng
            $totalStock += $v['stock'];

            $sizeGroups[$v['size']][] = [
                'color' => $v['color'],
                'stock' => $v['stock'],
                'variant_id' => $v['id']
            ];
        }

        $products['colors'] = $colors;
        $products['sizes'] = $sizes;
        $products['stock'] = $totalStock;
        $products['vid'] = $vid;
        $products['sizeGroups']  = $sizeGroups;

        $this->view('home/product_details', ['products' => $products]);
    }

    // về trang home (sp mơi nhất)
    public function home()
    {
        $products = $this->product->getNewProduct();
        foreach ($products as &$p) {
            $p['main_image'] = $this->image->getPrimaryImage($p['id']);
        }
        $this->view('home/main', [
            'newProducts' => $products
        ]);
    }
}
