<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class URL
{
    //======== LINK CATEGORY =========
    public static function linkCategory($id, $name)
    {
        return route('category/index', [
            'category_id' => $id,
            'category_name' => Str::slug($name)
        ]);
    }

    //======== LINK ARTICLE =========
    public static function linkArticle($id, $name)
    {
        return route('article/index', [
            'article_id' => $id,
            'article_name' => Str::slug($name)
        ]);
    }
}
