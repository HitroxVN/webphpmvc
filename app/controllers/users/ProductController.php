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
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(!empty($_GET['id'])){
                return $this->productDetails($_GET['id']);
            }
            if(!empty($_GET['search'])){
                // echo "search";
                return $this->findP();
            }
        }
        return $this->listProduct();
    }

    // tim kiếm sản phẩm theo tên
    public function findP(){
        $pro = $this->product->findProduct($_GET['search']);
        foreach ($pro as &$p) {
            $p['main_image'] = $this->image->getPrimaryImage($p['id']);
        }
        $this->view('home/products', ['products' => $pro]);
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
        $products = $this->product->getById($id);
        $products['main_image'] = $this->image->getPrimaryImage($products['id']);
        $products['list_images'] = $this->image->getUrlByProduct($products['id']);
        $variants = $this->variant->getByProductId($products['id']);

        $colors = [];
        $sizes = [];
        $totalStock = 0;
        $vid = null;

        $sizeGroups  = [];

        foreach ($variants as $v) {
            if (!in_array($v['color'], $colors)) {
                $colors[] = $v['color'];
            }
            if (!in_array($v['size'], $sizes)) {
                $sizes[] = $v['size'];
            }
            $vid = $v['id'];
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
