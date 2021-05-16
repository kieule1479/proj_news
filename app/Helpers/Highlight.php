<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class Highlight
{
    //======== SHOW ==                      =======
    public static function show($input, $paramsSearch, $field ){

        if($paramsSearch['value']== '') return $input;
        if($paramsSearch['field']== 'all'||$paramsSearch['field']== $field){
            return preg_replace("/".preg_quote($paramsSearch['value'],"/").'/i',"<span class='highlight'>$0</span>", $input);
        }
        return $input;
    }

}
