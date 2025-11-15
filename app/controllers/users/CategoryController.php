<?php

require_once __DIR__ . "/../../models/Category.php";
require_once __DIR__ . "/../../models/Product.php";
require_once __DIR__ . "/../../models/ProductImage.php";
require_once __DIR__ . "/../../core/Controller.php";

class CategoryController extends Controller {

    private $model;
    private $product;
    private $image;

    public function __construct()
    {
        $this->model = new Category();
        $this->product = new Product();
        $this->image = new ProductImage();
    }

    public function xulyRequest(){
        $this->listHome(); // load đầu tiên

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(!empty($_GET['id'])){
                $this->listProductByCategory($_GET['id']);
            }
        }
       
    }

    public function listProductByCategory($id){
        // echo "test";
        $product = $this->product->getByCategory($id);
        foreach ($product as &$p) {
            $p['main_image'] = $this->image->getPrimaryImage($p['id']);
        }
        $this->view('home/products', ['products' => $product]);
    }

    // về trang header home
    public function listHome(){
        $cate = $this->model->getAllHome();
        $this->view('home/header', ['categorys' => $cate]);
    }

}