<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\CategoryModel as MainModel;
use App\Http\Requests\CategoryRequest as MainRequest;



class CategoryController extends Controller
{

    private $pathViewController = 'admin.pages.category.';
    private $controllerName     = 'category';
    private $model;
    private $params = [];

    //===== __CONSTRUCT ======
    public function __construct()
    {
        $this->model = new MainModel();
        $this->params['pagination']['totalItemsPerPage'] = 5;
        view()->share('controllerName', $this->controllerName);
    }

    //===== INDEX ======
    public function index(Request $request)
    {
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');


        $items = $this->model->listItems($this->params, ['task' => 'admin_list_items']);
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin_count_items_group_by_status']);
        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'items'         => $items,
            'itemsStatusCount' => $itemsStatusCount,

        ]);
    }

    //===== FORM ======
    public function form(Request $request)
    {

        $item = null;
        if ($request->id != null) {
            $params['id'] = $request->id;
            $item = $this->model->getItem($params, ['task' => 'get-item']);
        }
        return view($this->pathViewController . 'form', [
            'item' => $item,

        ]);
    }

    //===== SAVE ======
    public function save(MainRequest $request)
    {

        if($request->method() =='POST'){
            $params = $request->all();// lấy tất cả phần tử được POST qua;

            $task   = 'add-item';
            $notify = 'Thêm phần tử thành công !';

            if($params['id'] != null){
                $task   = 'edit-item';
                $notify = 'Cập nhập phần tử thành công !';
            }

            $this->model->saveItem($params, ['task'=>$task]);
            return redirect()->route($this->controllerName)->with("zvn_notify", $notify);
        }
    }

    //===== STATUS ======
    public function status(Request $request)
    {

        $params["currentStatus"] = $request->status;
        $params["id"] = $request->id;
        $this->model->saveItem($params, ['task' => 'change-status']);
        return redirect()->route($this->controllerName)->with('zvn_notify', 'Cập nhập trạng thái thành công !!!');
    }

    //===== IS HOME ======
    public function isHome(Request $request)
    {
        $params["currentIsHome"] = $request->isHome;
        $params["id"]            = $request->id;
        $this->model->saveItem($params, ['task' => 'change-is-home']);
        return redirect()->route($this->controllerName)->with('zvn_notify', 'Cập nhập trạng thái hiển thị trang chủ thành công !!!');
    }

    //======== DISPLAY =========
    public function display(Request $request){
        $params['currentDisplay'] = $request->display;
        $params['id']             = $request->id;

        $this->model->saveItem($params, ['task' => 'change-display']);
        return redirect()->route($this->controllerName)->with('zvn_notify', 'Cập nhập kiểu hiển thị thành công !!!');


    }

    //===== DELETE ======
    public function delete(Request $request)
    {
        $params["id"] = $request->id;
        $this->model->deleteItem($params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notify', 'Xoá phần tử thành công thành công !!!');
    }
}


