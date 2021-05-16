<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\View;


class DashboardController extends Controller
{

    private $pathViewController = 'admin.pages.dashboard.';
    private $controllerName     = 'dashboard';

    //======== __CONSTRUCT =========
    public function __construct()
    {
        // View::share('controllerName', $this->controllerName);
        view()->share('controllerName', $this->controllerName);
    }

    //======== INDEX =========
    public function index()
    {
        return view($this->pathViewController . 'index', []);
    }


}
