<?php
require_once __DIR__ . "/../../models/User.php";
require_once __DIR__ . "/../../core/Controller.php";

class UserController extends Controller
{
    private $p;

    public function __construct()
    {
        $this->p = new User();
    }

    public function xulyRequest(){
        return $this->list();
    }

    // Lấy danh sách user
    public function list()
    {
        $users = $this->p->getByRole("customer");
        $this->view('staff/users', ['users' => $users]);
    }
}
