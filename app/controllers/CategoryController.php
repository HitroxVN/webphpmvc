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
        $this->view('admin/categorys', ['categorys' => $cate]);
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
            $check = $this->model->getByName($name);
            
            if($check && $check['status'] !== 'deleted'){
                return;
            } elseif ($check && $check['status'] === 'deleted') {
                $this->model->update($check['id'], $name, 'active');
            } else {
                $this->model->create(trim($name));
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
            $this->model->update($id, trim($name), $status);
            $this->redirect('index.php?page=categorys');
        }
    }

    // xóa danh mục
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $this->model->delete($_POST['id']);
            $this->redirect('index.php?page=categorys');
        }
    }

}