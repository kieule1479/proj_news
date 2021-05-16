<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SliderModel;
use App\Models\ArticleModel;
use App\Models\CategoryModel;





class HomeController extends Controller
{

    private $pathViewController = 'news.pages.home.';
    private $controllerName = 'home';
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
        $sliderModel   = new SliderModel();
        $categoryModel = new CategoryModel();
        $articleModel  = new ArticleModel();

        $itemsSlider   = $sliderModel->listItems(null, ['task' => 'news-list-items']);
        $itemsCategory = $categoryModel->listItems(null, ['task' => 'news-list-items-is-home']);
        $itemsFeatured = $articleModel->listItems(null, ['task' => 'news-list-items-is-featured']);
        $itemsLatest   = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);

        foreach ($itemsCategory as $key => $category)
            $itemsCategory[$key]['articles'] = $articleModel->listItems(['category_id' => $category['id']], ['task' => 'news-list-items-in-category']);


        return view($this->pathViewController . 'index', [
            'params'        => $this->params,
            'itemsSlider'   => $itemsSlider,
            'itemsCategory' => $itemsCategory,
            'itemsFeatured' => $itemsFeatured,
            'itemsLatest'   => $itemsLatest,
        ]);
    }
}
