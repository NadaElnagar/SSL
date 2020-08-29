<?php


namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Http\Requests\CheckLoginAdmin;
use Modules\Admin\Http\Service\AdminService;


class LoginController extends Controller
{
    private $admin;
    public function __construct()
    {
        $this->admin = new AdminService();
    }

    public function login(CheckLoginAdmin $request)
    {
        return $this->admin->login($request);
    }
}
