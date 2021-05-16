<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class Template
{
    //===== SHOW ITEMS HISTORY ======
    public static function showItemsHistory($by, $time)
    {
        $xhtml = sprintf(
            '<p><i class="fa fa-user"></i> %s</p>
            <p><i class="fa fa-clock-o"></i> %s</p>',
            $by,
            date(Config::get('zvn.format.short_time'), strtotime($time))
        );
        return $xhtml;
    }

    //===== SHOW BUTTON FILTER ======
    public static function showAreaSearch($controllerName, $paramsSearch)
    {
        $xhtml             = null;
        $tmpField          = Config::get('zvn.templates.search');
        $fieldInController = Config::get('zvn.config.search');
        $controllerName    = (array_key_exists($controllerName, $fieldInController)) ? $controllerName : 'default';
        $xhtmlField        = null;

        foreach ($fieldInController[$controllerName] as $field) {
            $xhtmlField .= sprintf(
                '<li><a href="#" class="select-field" data-field="%s">%s </a></li>',
                $field,
                $tmpField[$field]['name']
            );
        }

        $searchField = (in_array($paramsSearch['field'], $fieldInController[$controllerName])) ? $paramsSearch['field'] : 'all';

        $xhtml = sprintf(
            '<div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle btn-active-field" data-toggle="dropdown" aria-expanded="false">
                        %s <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        %s
                    </ul>
                </div>
                <input type="text" name="search_value" value="%s" class="form-control">
                <input type="hidden" name="search_field" value="%s">
                <span class="input-group-btn">
                    <button id="btn-clear-search" type="button" class="btn btn-success" style="margin-right: 0px">Xóa tìm kiếm</button>
                    <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                </span>

            </div>',
            $tmpField[$searchField]['name'],
            $xhtmlField,
            $paramsSearch['value'],
            $searchField
        );
        return $xhtml;
    }
    //===== SHOW BUTTON FILTER ======
    public static function showButtonFilter($controllerName, $itemsStatusCount, $currentFilterStatus, $paramsSearch)
    {
        $tmplStatus = Config::get('zvn.templates.status');
        $xhtml      = null;

        if (count($itemsStatusCount) > 0) {

            array_unshift($itemsStatusCount, [
                'count'  => array_sum(array_column($itemsStatusCount, 'count')),
                'status' => 'all'
            ]);

            foreach ($itemsStatusCount as $item) {

                $statusValue           = $item['status'];
                $statusValue           = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';
                $currentTemplateStatus = $tmplStatus[$statusValue];
                $link                  = route($controllerName) . "?filter_status=" . $statusValue;

                if ($paramsSearch['value'] != '') {
                    $link .= "&search_field=" . $paramsSearch['field'] . "&search_value=" . $paramsSearch['value'];
                }

                $class = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-info';

                $xhtml .= sprintf('<a href="%s" type="button" class="btn %s">
                            %s  <span class="badge bg-white">%s</span>
                            </a>', $link, $class, $currentTemplateStatus['name'], $item['count']);
            }
        }
        return $xhtml;
    }

    //======== SHOW ITEMS SELECT =========
    public static function showItemsSelect($controllerName, $id, $displayValue, $fieldName){
        $link = route($controllerName.'/'. $fieldName, [$fieldName=>'value_new', 'id'=>$id]);


        $tmpDisplay = Config::get('zvn.templates.'. $fieldName);


        $xhtml      = sprintf('<select name="select_change_attr" data-url="%s" class="form-control">', $link);

        foreach ($tmpDisplay as $key => $value) {
            $xhtmlSelected = '';
            if($key == $displayValue) $xhtmlSelected = 'selected = "selected"';
            $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
        }
        $xhtml .= '</select>';
        return $xhtml;

    }

    //===== SHOW ITEMS IS HOME ======
    public static function showItemsIsHome($controllerName, $id, $isHomeValue)
    {
        $tmplIsHome  = Config::get('zvn.templates.is_home');

        $isHomeValue = array_key_exists($isHomeValue, $tmplIsHome) ? $isHomeValue : 'yes';

        $currentTemplateIsHome = $tmplIsHome[$isHomeValue];
        $link          = route($controllerName . '/isHome', ['is_home' => $isHomeValue, 'id' => $id]);
        $xhtml         = sprintf(
                                    '<a href="%s" type="button" class="btn btn-round %s">%s</a>',
                                    $link,
                                    $currentTemplateIsHome['class'],
                                    $currentTemplateIsHome['name']
                                );
        return $xhtml;
    }
    //===== SHOW ITEMS STATUS ======
    public static function showItemsStatus($controllerName, $id, $statusValue)
    {
        $tmplStatus  = Config::get('zvn.templates.status');
        $statusValue = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';

        $currentTemplateStatus = $tmplStatus[$statusValue];
        $link          = route($controllerName . '/status', ['status' => $statusValue, 'id' => $id]);
        $xhtml         = sprintf(
            '<a href="%s" type="button" class="btn btn-round %s">%s</a>',
            $link,
            $currentTemplateStatus['class'],
            $currentTemplateStatus['name']
        );
        return $xhtml;
    }

    //===== SHOW ITEMS THUMB ======
    public static function showItemsThumb($controllerName, $thumbName, $thumbAlt)
    {
        $xhtml = sprintf(
            '<img src="%s" alt=" %s" class="zvn-thumb">',
            asset("images/$controllerName/$thumbName"),
            $thumbAlt
        );
        return $xhtml;
    }

    //===== SHOW BUTTON ACTION ======
    public static function showButtonAction($controllerName, $id)
    {
        $tmpButton    = Config::get('zvn.templates.button');
        $buttonInArea = Config::get('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : "default";
        $listButton     = $buttonInArea[$controllerName];

        $xhtml          = ' <div class="zvn-box-btn-filter">';

        foreach ($listButton as $btn) {
            $currentButton = $tmpButton[$btn];
            $link          = route($controllerName . $currentButton['route-name'], ['id' => $id]);

            $xhtml .= sprintf(
                '<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top"    data-original-title="%s">
                    <i class="fa %s"></i>
                </a>',
                $link,
                $currentButton['class'],
                $currentButton['title'],
                $currentButton['icon']
            );
        }

        $xhtml .= '</div>';
        return $xhtml;
    }

    //======== SHOW DATE TIME FRONTEND =========
    public static function showDateTimeFrontend($dateTime){
        return date_format(date_create($dateTime), Config::get('zvn.format.short_time'));
    }

    //======== SHOW CONTENT =========
    public static function showContent($content, $length, $prefix= '...'){
        $prefix  = ($length == 0)? '' : $prefix;
        $content = str_replace(['<p>','</p>'], '', $content);
        return preg_replace('/\s+?(\S+)?$/', '', substr($content,0, $length)). $prefix;
    }
}
