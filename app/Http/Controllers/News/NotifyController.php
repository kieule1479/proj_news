<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleModel;



class NotifyController extends Controller
{

    private $pathViewController = 'news.pages.notify.';
    private $controllerName = 'notify';
    private $params = [];
    private $model;

    //===== __CONSTRUCT ======
    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    //===== INDEX ======
    public function noPermission(Request $request)
    {

        $articleModel  = new ArticleModel();


        $itemsLatest   = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);

        return view($this->pathViewController . 'no-permission', [
            'itemsLatest'   => $itemsLatest,
        ]);
    }
}
