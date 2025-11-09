<?php

require_once __DIR__ . "/../models/Category.php";
require_once __DIR__ . "/../core/Controller.php";

class CategoryController extends Controller {

    private $model;

    public function __construct()
    {
        $this->model = new Category();
    }

    // load danh mục về trang admin
    public function list(){
        $cate = $this->model->getAll();
        $thongbao = $_SESSION['thongbao'] ?? null;
        unset($_SESSION['thongbao']);
        $this->view('admin/categorys', [
            'categorys' => $cate,
            'thongbao' => $thongbao
        ]);
    }

    // về trang home
    public function listHome(){
        $cate = $this->model->getAllHome();
        $this->view('home/header', ['categorys' => $cate]);
    }

    // Thêm danh mục
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['add_name'])) {
            $name = strtolower($_POST['add_name']);
            if($this->model->getByName($name)){
                $_SESSION['thongbao'] = "Danh mục này đã tồn tại";
            } else {
                $this->model->create(trim($name));
                $_SESSION['thongbao'] = "Thêm danh mục thành công";
            }
            $this->redirect('index.php?page=categorys');
        }
    }

    // sửa danh mục
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = strtolower($_POST['name']);
            $status = $_POST['status'];
            $check = $this->model->getByName($name);
            if($check && $check['id'] != $id) {
                $_SESSION['thongbao'] = "Tên danh mục này đã tồn tại";
            } else {
                $this->model->update($id, trim($name), $status);
                $_SESSION['thongbao'] = "Cập nhập danh mục thành công";
            }
            $this->redirect('index.php?page=categorys');
        }
    }

    // xóa danh mục
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $this->model->delete($_POST['id']);
            $_SESSION['thongbao'] = "Xoá danh mục thành công";
            $this->redirect('index.php?page=categorys');
        }
    }

}