<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use App\Models\CategoryModel;





class ArticleController extends Controller
{

    private $pathViewController = 'news.pages.article.';
    private $controllerName = 'article';
    private $params = [];
    private $model;

    //===== __CONSTRUCT ======
    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    //===== INDEX ======
    public function index(Request $request)
    {


        $params['article_id']= $request->article_id;
        $articleModel  = new ArticleModel();

        $itemArticle = $articleModel->getItem($params,['task'=>'news-get-item']);

        if(empty($itemArticle)) return redirect()->route('home');

        $itemsLatest   = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);
        $params['category_id'] = $itemArticle['category_id'];


        $itemArticle['related_articles']= $articleModel->listItems($params, ['task' => 'news-list-items-related-in-category']);


        return view($this->pathViewController . 'index', [
            'params'        => $this->params,
            'itemsLatest'   => $itemsLatest,
            'itemArticle'   => $itemArticle,
        ]);
    }
}
