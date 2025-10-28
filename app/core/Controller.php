<?php

class Controller {
    // truyền dữ liệ sang view
    protected function view($view, $data = []) {
        $viewPath = __DIR__ . "/../views/{$view}.php";
        
        if (file_exists($viewPath)) {
            extract($data);
            require_once $viewPath;
        } else {
            echo "View {$view} không tồn tại!";
        }
    }

    // chuyển hướng url
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}
