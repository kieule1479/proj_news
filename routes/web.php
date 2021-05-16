<?php

use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$prefixAdmin = config('zvn.url.prefix_admin');
$prefixNews  = config('zvn.url.prefix_news');


Route::get('/', function () {
    return view('welcome');
});




//!=================================================== ADMIN 123 =======================================================
Route::group(['prefix' => $prefixAdmin, 'namespace' => 'Admin', 'middleware'=>['permission.admin']], function () {
    Route::get('user', function () {
        return '/admin/user';
    });

    //===== DASHBOARD ======
    $prefix         = 'dashboard';
    $controllerName = 'dashboard';

    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';

        Route::get('/',            ['as'   => $controllerName,             'uses' => $controller . 'index']);

    });

    //===== SLIDER ======
    $prefix         = 'slider';
    $controllerName = 'slider';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';

        Route::get('/',            ['as'   => $controllerName,             'uses' => $controller . 'index']);
        Route::get('/form/{id?}',  ['as'   => $controllerName . '/form',   'uses' => $controller . 'form',])->where('id', '[0-9]+');
        Route::post('/save',       ['as'   => $controllerName . '/save',  'uses' => $controller . 'save']);
        Route::get('/delete/{id}', ['as'   => $controllerName . '/delete',  'uses' => $controller . 'delete',])->where('id', '[0-9]+');
        Route::get('/change-status-{status}/{id}',  ['as'   => $controllerName . '/status',   'uses' => $controller . 'status',])->where('id', '[0-9]+');
    });

    //===== CATEGORY ======
    $prefix         = 'category';
    $controllerName = 'category';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';

        Route::get('/',            ['as'   => $controllerName,             'uses' => $controller . 'index']);
        Route::get('/form/{id?}',  ['as'   => $controllerName . '/form',   'uses' => $controller . 'form',])->where('id', '[0-9]+');
        Route::post('/save',       ['as'   => $controllerName . '/save',  'uses' => $controller . 'save']);
        Route::get('/delete/{id}', ['as'   => $controllerName . '/delete',  'uses' => $controller . 'delete',])->where('id', '[0-9]+');
        Route::get('/change-status-{status}/{id}',  ['as'   => $controllerName . '/status',   'uses' => $controller . 'status',])->where('id', '[0-9]+');
        Route::get('/change-is-home-{isHome}/{id}',  ['as'   => $controllerName . '/isHome',   'uses' => $controller . 'isHome',])->where('id', '[0-9]+');
        Route::get('/change-display-{display}/{id}',  ['as'   => $controllerName . '/display',   'uses' => $controller . 'display',])->where('id', '[0-9]+');

    });

    //===== ARTICLE ======
    $prefix         = 'article';
    $controllerName = 'article';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';

        Route::get('/',            ['as'   => $controllerName,             'uses' => $controller . 'index']);
        Route::get('/form/{id?}',  ['as'   => $controllerName . '/form',   'uses' => $controller . 'form',])->where('id', '[0-9]+');
        Route::post('/save',       ['as'   => $controllerName . '/save',  'uses' => $controller . 'save']);
        Route::get('/delete/{id}', ['as'   => $controllerName . '/delete',  'uses' => $controller . 'delete',])->where('id', '[0-9]+');
        Route::get('/change-status-{status}/{id}',  ['as'   => $controllerName . '/status',   'uses' => $controller . 'status',])->where('id', '[0-9]+');

        Route::get('/change-type-{type}/{id}',  ['as'   => $controllerName . '/type',   'uses' => $controller . 'type',])->where('id', '[0-9]+');


    });
    //===== USER ======
    $prefix         = 'user';
    $controllerName = 'user';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';

        Route::get('/',            ['as'   => $controllerName,             'uses' => $controller . 'index']);
        Route::get('/form/{id?}',  ['as'   => $controllerName . '/form',   'uses' => $controller . 'form',])->where('id', '[0-9]+');
        Route::post('/save',       ['as'   => $controllerName . '/save',  'uses' => $controller . 'save']);
        Route::post('/change-password',  ['as'   => $controllerName . '/change-password',  'uses' => $controller . 'changePassword']);
        Route::post('/change-level',  ['as'   => $controllerName . '/change-level',  'uses' => $controller . 'changeLevel']);
        Route::get('/delete/{id}', ['as'   => $controllerName . '/delete',  'uses' => $controller . 'delete',])->where('id', '[0-9]+');
        Route::get('/change-status-{status}/{id}',  ['as'   => $controllerName . '/status',   'uses' => $controller . 'status',])->where('id', '[0-9]+');

        Route::get('/change-level-{level}/{id}',  ['as'   => $controllerName . '/level',   'uses' => $controller . 'level',])->where('id', '[0-9]+');


    });

});




//!=================================================== NEW 69 =======================================================
Route::group(['prefix' => $prefixNews, 'namespace'=>'News'], function () {

    //===== HOME PAGE ======
    $prefix         = '';
    $controllerName = 'home';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/',            ['as'   => $controllerName,  'uses' => $controller . 'index']);

    });


    //===== CATEGORY ======
    $prefix         = 'chuyen-muc';
    $controllerName = 'category';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {

        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/{category_name}-{category_id}.html', ['as'   => $controllerName. '/index',  'uses' => $controller . 'index'])
            ->where('category_name', '[0-9a-zA-Z_-]+')
            ->where('category_id', '[0-9]+');
    });

    //===== ARTICLE ======
    $prefix         = 'bai-viet';
    $controllerName = 'article';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {

        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/{article_name}-{article_id}.html', ['as'   => $controllerName. '/index',  'uses' => $controller . 'index'])
            ->where('article_name', '[0-9a-zA-Z_-]+')
            ->where('article_id', '[0-9]+');
    });

    //===== NOTIFY ======
    $prefix         = '';
    $controllerName = 'notify';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {

        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/no-permission', ['as'   => $controllerName . '/noPermission',  'uses' => $controller . 'noPermission']);

    });


    //===== LOGIN ======
    $prefix         = '';
    $controllerName = 'auth';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {

        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/login', ['as'   => $controllerName . '/login',  'uses' => $controller . 'login'])->middleware('check.login');
        Route::post('/postLogin', ['as'   => $controllerName . '/postLogin',  'uses' => $controller . 'postLogin']);
        //===== LOGOUT ======
        Route::get('/logout', ['as'   => $controllerName . '/logout',  'uses' => $controller . 'logout']);


    });

});
